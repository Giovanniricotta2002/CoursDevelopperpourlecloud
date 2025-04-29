<?php

namespace App\Controller;

use App\Entity\Licences;
use App\Enum\Status;
use App\Repository\LicencesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use ValueError;
use Nelmio\ApiDocBundle\Attribute\Model as AttributeModel;
use OpenApi\Attributes as OA;

#[Route('/licences', name: 'app_licences')]
final class LicencesController extends AbstractController
{
    private Serializer $serializer;

    public function __construct(
        private LicencesRepository $licencesRepository,
        private readonly EntityManagerInterface $em,
    ) {
        $normalize = [new ObjectNormalizer()];
        $encoder = [new JsonEncoder(), new XmlEncoder(), new CsvEncoder(), new YamlEncoder()];
        $this->serializer = new Serializer($normalize, $encoder);
    }

    #[Route('/new', name: '_post', methods: ['POST'], stateless: true)]
    #[OA\Tag(name: 'Licences')]
    #[OA\Post(
        path: '/licences/new',
        summary: 'Create a new licence',
        requestBody: new OA\RequestBody(
            description: 'Licence data',
            required: true,
            content: new OA\JsonContent(
                type: 'object',
                properties: [
                    new OA\Property(property: 'tenant', type: 'string'),
                    new OA\Property(property: 'clientId', type: 'integer'),
                    new OA\Property(property: 'name', type: 'string'),
                    new OA\Property(property: 'api_name', type: 'string'),
                    new OA\Property(property: 'licence_key', type: 'string'),
                    new OA\Property(property: 'status', type: 'string'),
                    new OA\Property(property: 'expirationDate', type: 'string', format: 'date-time'),
                    new OA\Property(property: 'usageLimite', type: 'integer'),
                    new OA\Property(property: 'usageCount', type: 'integer'),
                    new OA\Property(property: 'rateLimit', type: 'integer'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Licence created',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'res', ref: new AttributeModel(type: Licences::class))
                    ]
                )
            ),
            new OA\Response(response: 406, description: 'Invalid input'),
            new OA\Response(response: 404, description: 'Server error'),
        ]
    )]
    public function new(Request $request): Response
    {
        $data = [];
        if ('application/json' == $request->getContentTypeFormat()) {
            $data = new ParameterBag($this->serializer->decode($request->getContent(), 'json'));
        } else {
            $data = $request->request;
        }

        $status = null;

        try {
            foreach (['tenant', 'clientId', 'name', 'api_name', 'licence_key', 'status', 'expirationDate', 'usageLimite', 'usageCount', 'rateLimit'] as $key) {
                if ('status' == $key) {
                    $status = Status::from($data->get('status'));
                } else {
                    if (!$data->has($key)) {
                        return $this->json('Clé non trouvé', Response::HTTP_NOT_ACCEPTABLE);
                    }
                }
            }
        } catch (ValueError $ve) {
            return $this->json('Status non trouvé', Response::HTTP_NOT_ACCEPTABLE);
        }

        $licence = new Licences();
        $licence->setTenant($data->getString('tenant'));
        $licence->setClientId($data->getInt('clientId'));
        $licence->setName($data->getString('name'));
        $licence->setApiName($data->getString('api_name'));
        $licence->setLicenceKey($data->getString('licence_key'));
        $licence->setStatus($status);
        $licence->setLicenceKey($data->get('expirationDate'));
        $licence->setUsageLimite($data->getInt('usageLimite'));
        $licence->setUsageCount($data->getString('usageCount'));
        $licence->setRateLimit($data->getInt('rateLimit'));


        try {
            $this->em->persist($licence);
            $this->em->flush();
        } catch (ORMException $orm) {
            return $this->json('Erreurs serveur', Response::HTTP_NOT_FOUND);
        }

        return $this->json(['res' => $this->serializer->normalize($licence)], Response::HTTP_CREATED);
    }

    #[Route('/{tenant}', name: '_get', methods: ['GET'])]
    #[OA\Get(
        path: '/licences/{tenant}',
        summary: 'Get licences by tenant',
        parameters: [
            new OA\Parameter(
                name: 'tenant',
                in: 'path',
                required: true,
                description: 'Tenant identifier',
                schema: new OA\Schema(type: 'string')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Licence data',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(
                            property: 'licence',
                            type: 'array',
                            items: new OA\Items(ref: Licences::class)
                        )
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Licence not found'),
        ]
    )]
    public function show(string $tenant): Response
    {
        $licence = $this->licencesRepository->findBy(['tenant' => $tenant]);

        return $this->json(['licence' => $licence], Response::HTTP_OK);
    }

    #[Route('/{tenant}', name: '_delete', methods: ['DELETE'], stateless: true)]
    #[OA\Delete(
        path: '/licences/{tenant}',
        summary: 'Delete a licence by tenant',
        parameters: [
            new OA\Parameter(
                name: 'tenant',
                in: 'path',
                required: true,
                description: 'Tenant identifier',
                schema: new OA\Schema(type: 'string')
            )
        ],
        responses: [
            new OA\Response(response: 303, description: 'Licence deleted'),
            new OA\Response(response: 404, description: 'Licence not found'),
        ]
    )]
    public function delete(string $tenant): Response
    {
        $licence = $this->licencesRepository->findOneBy(['tenant' => $tenant]);

        $this->em->remove($licence);
        $this->em->flush();

        return $this->json([], Response::HTTP_SEE_OTHER);
    }
}

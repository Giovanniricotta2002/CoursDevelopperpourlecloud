#

kind create cluster --config ./cluster.yaml
helm repo add kubernetes-dashboard https://kubernetes.github.io/dashboard/
helm upgrade --install kubernetes-dashboard kubernetes-dashboard/kubernetes-dashboard --create-namespace --namespace kubernetes-dashboard
kubectl2 -n kubernetes-dashboard port-forward svc/kubernetes-dashboard-kong-proxy 8443:443
kubectl2 apply -f ./k8s-dashboard-service-accounts.yaml
kubectl -n kubernetes-dashboard create token admin-user
helm install my-release oci://registry-1.docker.io/bitnamicharts/postgresql <- postgress
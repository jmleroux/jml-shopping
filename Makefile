build:
	docker build --target prod -t europe-west1-docker.pkg.dev/test4422rh/jmleroux-pro/jmlshopping:latest .
	docker push europe-west1-docker.pkg.dev/test4422rh/jmleroux-pro/jmlshopping:latest

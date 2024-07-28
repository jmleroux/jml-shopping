setup:
	cp -n src/firebaseConfig.dist.js src/firebaseConfig.js
	docker compose build

dev:
	${MAKE} setup
	docker compose run --rm node yarn dev

build:
	docker build --target prod -t europe-west1-docker.pkg.dev/test4422rh/jmleroux-pro/jmlshopping:latest .
	docker push europe-west1-docker.pkg.dev/test4422rh/jmleroux-pro/jmlshopping:latest

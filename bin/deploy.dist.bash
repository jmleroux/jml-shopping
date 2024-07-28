#!/usr/bin/bash
docker build --target prod -t europe-west1-docker.pkg.dev/my_project_id/my_id/jmlshopping:latest .
docker push europe-west1-docker.pkg.dev/my_project_id/my_id/jmlshopping:latest

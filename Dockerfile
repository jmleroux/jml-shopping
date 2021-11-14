FROM node:16-slim as base

EXPOSE 8080
# If yout want use vue-cli UI you need to also EXPORT 8000

CMD [ "yarn", "serve" ]


FROM base as dev

RUN apt-get -y update && apt-get install -y git

RUN yarn global add @vue/cli -g

WORKDIR /srv/jmleroux

RUN apt-get autoremove -y \
    && apt-get autoclean -y \
    && apt-get clean -y \
    && rm -rf /var/lib/apt/lists/*

USER node

FROM node:16-slim as base

EXPOSE 8080
# If yout want use vue-cli UI you need to also EXPORT 8000


FROM base as dev

RUN apt-get -y update && apt-get install -y git

RUN yarn global add @vue/cli -g

WORKDIR /app

RUN apt-get autoremove -y \
    && apt-get autoclean -y \
    && apt-get clean -y \
    && rm -rf /var/lib/apt/lists/*

USER node


FROM base as builder
WORKDIR /app
COPY package*.json ./
RUN yarn install --frozen-lockfiles
COPY ./ .
RUN yarn build


FROM nginx as prod
RUN mkdir /app
COPY --from=builder /app/dist /app
COPY nginx.conf /etc/nginx/nginx.conf

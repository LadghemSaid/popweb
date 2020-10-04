
# 1st stage : build js & css
FROM node:12-alpine as builder

ENV NODE_ENV=production
WORKDIR /srv/app

ADD package.json webpack.config.js ./
ADD assets ./assets

RUN mkdir -p public && \
    NODE_ENV=development yarn install && \
    yarn run build
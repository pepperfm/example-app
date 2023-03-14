FROM node:18-alpine

ARG DOCKER_GROUP_ID
ARG DOCKER_USER_ID
ARG CUSTOM_VITE_PORT

WORKDIR /var/www/example-app

USER root

RUN apk --no-cache add shadow && usermod -u $DOCKER_USER_ID node && groupmod -g $DOCKER_GROUP_ID node

COPY package*.json ./

RUN npm install -g npm@latest

RUN npm i

# Fix user permissions
RUN chown -R node:node /var/www/example-app && \
    chmod 755 /var/www/example-app

USER node

COPY . .

EXPOSE $CUSTOM_VITE_PORT

CMD [ "npm", "run", "dev" ]

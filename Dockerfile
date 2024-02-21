FROM node:20.11.1

RUN mkdir -p /home/node/app/node_modules && chown -R node:node /home/node/app

WORKDIR /home/node/app

COPY --chown=node:node package*.json ./

USER node

COPY --chown=node:node . .

CMD ["tail", "-f", "/dev/null"]
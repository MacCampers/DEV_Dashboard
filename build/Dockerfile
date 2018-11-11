FROM node:8.9

RUN mkdir -p /usr/src/app

WORKDIR /usr/src/app

COPY package.json /usr/src/app/

RUN npm install @angular/cli

RUN npm install --silent

COPY . /usr/src/app/

EXPOSE 8080

CMD ["npm", "start"]

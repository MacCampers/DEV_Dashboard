FROM node:8.9

ENV HOME /usr/src/app

COPY . $HOME

WORKDIR $HOME

RUN npm install

RUN npm install @angular/cli

CMD ng serve --host 0.0.0.0
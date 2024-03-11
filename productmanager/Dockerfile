FROM node:latest

WORKDIR /frontend

COPY . .

RUN npm install

EXPOSE 8080

CMD ["npm", "run", "serve"]

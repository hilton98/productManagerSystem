# productManagerSystem
Sistema para gerenciamento de produtos, possibilitando ao usuário visualizar, criar, editar e remover produtos.

# Sobre o projeto
Sistema de arquitetura REST, sendo a API desenvolvida com laravel 10 e o frontend com Vuejs 3. O backend busca aplicar uma padronização de código e visa tornar fácil a manutenção e reaproveotamento de código ao utilizar alguns conceitos de clean architecture em sua estrutura. Em relação ao frontend, existem alguns recursos que ficaram pendentes para desenvolver por falta de tempo. Utilizei alguns recursos do Bootstrap, não tenho muitas aspirações artísticas então deixei sem muitas estilizações, se comprometendo mais em realizar a integração com a API.

# Instalação do sistema

1. Clonar o repositório
2. selecionar a branch develop: `git checkout develop`
3. criar um `.env` com os dados do arquivo `.env.example`

### 4. Configurar o `backend` com os comandos:
```
cd backend
composer install
docker-compose up -d
```
6. Executar as migrações com o comando:
```
./vendor/bin/sail artisan migrate

```

### 7. Configurar o `frontend` com os comandos:
```
cd productmanager
npm i
```

8. Executar o frontend:
```
npm run serve
```

obs: Em breve add o docker para automatizar a instalação... sorry :)

# Esquema banco de dados
- Inicialmente foram pensadas em 3 entidades: Product, Category e Stock. 
- Por padrão todo produto tem relação com alguma categoria. Inicialmente a entidade Stock tem vínculo com o usuário e com o produto, fazendo com que o usuário possua seu estoque de produtos.
- O Stock deve evoluir futuramente ao add novas colunas que indicam quantidades e entre outras informações pertinentes. 
- Ao deletar um produto, o produto é deletado do Stock e não literalmente o produto.
- As categorias são compartilhadas por todos, ao serem criadas não são vinculadas ao usuário.

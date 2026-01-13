transformer le .env.dist en .env grâce à cette commande:
cp .env.dist .env
faire docker-compose up -d
directus peut s'éteindre parce que la base de donnée n'est pas lancé avant, il suffit de le relancer
puis mettre la sauvegarde sur docker:
docker-compose cp ./sauvegarde_directus/snapshot.yaml directus:/directus/snapshot.yaml

puis la charger:
docker-compose exec directus npx directus schema apply ./snapshot.yaml

ensuite importer les différents csv dans les tables sur directus

profiles utilisateurs:
Admin:
email: admin@example.com
mdp: admin

Token statique:
email: tokenstatique@mail.com
token: Bearer OPmDo-0L6DFil3sWTOwwGgxnsLHmtAom

Token JWT:
email: TokenJWT@mail.fr
mdp: TokenJWT
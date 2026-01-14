transformer le .env.dist en .env grâce à cette commande:
cp .env.dist .env
faire docker-compose up -d

allez sur http://localhost:8080/
Puis mettre les identifiants de prat.env, à savoir que le serveur s'appelle praticien.db et que le système est PostgreSQl
aller dans requete SQL puis copier le contenu de prati.shema.sql dans le dossier sql puis l'executer.
faire ensuite de même avec prati.data.sql.

puis aller sur http://localhost:3080/
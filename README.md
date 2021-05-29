## Lancer l'application

- php -S localhost:8000 -t public


## Commandes utiles

#####Maker

```
exec php bin/console make:controller
exec php bin/console make:entity
exec php bin/console make:form
```

#####Mise à jour de votre BDD

```
php bin/console doctrine:schema:update --dump-sql
php bin/console doctrine:schema:update --force
```

## STUD&BUDDY by Céline, Bérenger, Mathieu, Nathalie, Victor

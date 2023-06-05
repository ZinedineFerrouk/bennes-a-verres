# Projet benne à verre

## Projet présenté par

Basile, Zinedine, Maxime, Dylan et Médéric

### Pré-requis

- Git version 2.x
- Une clé ssh liée à votre compte github (https://github.com/settings/keys)

### Installation

- Ouvrir git bash dans votre dossier serveur (htdocs...)
- Dans git bash  tapper`git clone git@github.com:medericcareil-rhesia/benne-a-verre.git`
- Déplacer vous dans le dossier du projet `cd benne-a-verre`
- Pour récupérer toutes les branches `git fetch -v --all`
- Ensuite allez sur votre branche `git checkout votre nom` exemple : `git checkout basile`
- A la racine du projet crée le fichier `.env.local` et copié y le contenu du `.env` dedans
- Ensuite modifié la variable `DATABASE_URL` => `DATABASE_URL="mysql://root:{root si mac sinon vide}@127.0.0.1:3306/benne-a-verre?serverVersion={votre version de php my admin}"`

Après cela ouvrir un terminal à la racine du projet et tapper les instructions suivante :

- `composer install`
- `symfony console d:d:c`
- `symfony console make:migration`
- `symfony console d:m:m`
- `symfony console d:f:l --no-interaction`

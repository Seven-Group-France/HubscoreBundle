# SevengroupHubscoreBundle

## Installation

Copier le fichier config/packages/sevengroup_hubscore.yaml dans le dossier config/packages du projet.


```shell
composer require sevengroupfrance/hubscore-bundle
```

## Utilisation

Include 
> Sevengroup\HubscoreBundle\Services\HubMailer

Si vous avez déjà un token Hubscore valide, appelez la fonction **setToken(token)**, sinon appelez la fonction **connection(username, password)**

Ensuite pour envoyer un mail utilisez la fonction **send('campaign',datas)**, dans lequel datas contient les données nécessaires et optionnel a l'envoi d'une campagne API disponible sur la documentation de [Hubscore](https://documentation.hub-score.com/#tag/Sending/paths/~1v1~1sends~1mails/post)
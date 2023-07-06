## Click&Boat - Test at home

## Context

Click&Boat sends automated emails to its owners and tenants. It is the AutomaticEmailManager class that takes care of replacing the placeholders of the email templates by the context values.

This class was created a long time ago and has evolved a lot over the years. It has accumulated many bad practices and is difficult to understand and evolve.

Today we want to make a clean up of this class to make it understandable and evolutive.

## Rules

- You have to modify the project sources to :
  - Eliminate bad practices
  - Make the AutomaticEmailManager class understandable and easier to evolve
- You can modify everything except the places where the PHPDoc specifies that you should not modify a certain part of the code
- The indicative time to solve is about one hour but it is possible that you finish in more or less time. Take the time you think is appropriate.

## Deliverable

You need to version this project on Gitlab.

- The project must contain the various commits of your development, allowing us to understand your logic of task distribution.
- The visibility of the project must be private and you must have access to the following user for review:
  - @jerome.ambroise_cab User ID: 5021411
- When everything is finished, please send an e-mail to jerome.ambroise@clickandboat.com

Good luck and see you soon ;

## Problème :

On cherche à refactoriser la classe AutomaticEmailManager pour la rendre plus claire et plus facile à maintenir.

## Observations

On remarque immédiatement que la classe possède une fonction build qui est très longue et qui contient beaucoup de logique. On va donc chercher à la découper en plusieurs fonctions plus petites et plus lisibles.

Commencons par analyser les traitements réalisés par la **fonction build** :

**Verification et traitement sur la partie langage**

- Elle commence par une validation des paramètres d'entrée : AutomaticEmail, data, isForPreview.
- Elle enchaine par un traitement sur la variabe langage : ce traitement consiste d'abord à définir la variable fallbackLanguage, par défaut cette variable aura la valeur "en".
- Un double if se charge ensuite de filtrer en utilisant la propriété "language_id" dans "data" ainsi que la propriété "recipient_account_id", si un de ces filtres fonctionne, il réassigne la valeur de la variable "language", autrement c'est la valeur par défaut, ou "fallbackLanguage" qui sera conservée.
- Ce traitement devrait être extrait dans une fonction à part.

**Récupération du template**

- On remarque ensuite qu'une fonction "array_filter" est chargée d'attribuer une valeur à la variable template. Pour cela elle filtre le tableau "template" en passant l'id du language. Le but étant de récupérer le template correspondant au bon language.
- Ici encore on a une unité logique qui pourrait devenir une fonction

**Personnalisation du template**

- Immédiatement après, on a un appel à la fonction replaceVar, elle remplace la variable "today" par la date du jour. Cela fait d'elle une excellente candidate pour devenir une fonction à part.

**Remplacement des variables introduction, recipient, product et signature**

- quatre blocs logiques assez similaires se suivent et ont pour objectif de terminer la construction du template avant de le retourner.
- un bloc est chargé de la variable "introduction".
- un autre de la variable "recipient" : il doit attribuer les propriétés nom, prénom, email et téléphone.
- un troisième de la variable "product" : il assigne les variables title, city,model, builder.
- un dernier s'occupe de construire la signature

Ces 4 blocs doivent également être découpés en plus petites fonctions.

### Conclusion

Si l'on résume, on doit créer 7 fonctions. Une concerne le langage, une autre la récupération du template qui correspond au langage.
Ensuite on se retrouve avec 5 fonctions qui se chargeront de remplacer les variables du template. De cette manière nous évitons de nous retrouver avec une fonction build trop longue et trop complexe.

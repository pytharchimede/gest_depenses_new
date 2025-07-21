# Fonctionnalité de Recherche Inversée - Guide d'Utilisation

## 🎯 Qu'est-ce que la recherche inversée ?

La fonctionnalité de **recherche inversée** vous permet d'inverser la logique de recherche dans le système de gestion des fiches de décaissement.

### Mode Normal (par défaut)

- ✅ **Inclut** les résultats qui correspondent aux critères de recherche
- Exemple : Si vous tapez "CISSE OUSMANE", vous verrez **toutes les fiches de CISSE OUSMANE**

### Mode Inversé

- ❌ **Exclut** les résultats qui correspondent aux critères de recherche
- Exemple : Si vous tapez "CISSE OUSMANE" avec la recherche inversée, vous verrez **toutes les fiches SAUF celles de CISSE OUSMANE**

## 🚀 Comment utiliser la fonctionnalité

### Interface utilisateur améliorée :

1. **Indicateur visuel** : La case à cocher change de couleur selon le mode

   - 🟢 **Vert** = Mode normal (inclut)
   - 🔴 **Rouge** = Mode inversé (exclut)

2. **Notifications contextuelles** : Des messages apparaissent quand vous changez de mode

3. **Aide contextuelle** : L'icône d'aide (?) explique la différence entre les modes

### Fonctionnement technique :

- ✅ Fonctionne avec tous les filtres (affectation, chantier, dates)
- ✅ Maintient l'état lors de la pagination
- ✅ S'applique également dans l'export PDF
- ✅ Sauvegardé en session pour maintenir l'état

## 📋 Exemples d'utilisation pratiques

### Cas 1 : Exclure un utilisateur spécifique

- Cochez "Recherche inversée"
- Tapez le nom de l'utilisateur à exclure
- Résultat : Voir toutes les fiches SAUF celles de cet utilisateur

### Cas 2 : Trouver toutes les fiches sauf celles d'une affectation

- Sélectionnez l'affectation dans le filtre
- Cochez "Recherche inversée"
- Résultat : Toutes les fiches SAUF celles de cette affectation

### Cas 3 : Audit et contrôle

- Parfait pour vérifier que certaines personnes N'ONT PAS de fiches
- Utile pour s'assurer qu'un chantier N'A PAS de dépenses en cours

## 🛠️ Améliorations apportées

### Interface utilisateur :

- **Label dynamique** : "Normale" ou "Inversée"
- **Indicateur textuel** : "Inclut les résultats" ou "Exclut les résultats"
- **Couleurs distinctives** : Vert pour normal, rouge pour inversé
- **Notifications** : Messages explicatifs lors du changement de mode
- **Placeholder dynamique** : Le champ de saisie adapte son texte d'aide

### Fonctionnalités techniques :

- **Cohérence** : Tous les événements JavaScript incluent le paramètre
- **Pagination** : Maintient le mode de recherche lors des changements de page
- **Export PDF** : Applique la même logique dans les exports
- **Session** : Sauvegarde l'état pour maintenir la cohérence

## ✅ Validation et tests

### Tests recommandés :

1. **Test basique** : Basculer entre les modes et vérifier l'affichage
2. **Test avec données** : Rechercher un nom existant dans les deux modes
3. **Test pagination** : Vérifier que le mode persiste lors du changement de page
4. **Test export** : S'assurer que le PDF respecte le mode sélectionné
5. **Test combiné** : Utiliser plusieurs filtres avec la recherche inversée

### Points de contrôle :

- [ ] L'interface change visuellement selon le mode
- [ ] Les notifications apparaissent lors du changement
- [ ] La recherche fonctionne correctement dans les deux modes
- [ ] La pagination maintient l'état
- [ ] L'export PDF respecte le mode sélectionné

## 🎨 Personnalisation

Le fichier CSS `css/recherche_inversee.css` contient tous les styles pour personnaliser l'apparence :

- Couleurs des indicateurs
- Animations des notifications
- Styles des conteneurs

Vous pouvez facilement modifier ces styles selon vos préférences visuelles.

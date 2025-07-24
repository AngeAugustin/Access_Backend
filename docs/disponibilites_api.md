# Documentation des Disponibilités - API Complete

## Nouveaux champs de disponibilité

L'entité `Educateur` a été enrichie avec des champs structurés pour les disponibilités :

### Structure des données

Pour chaque disponibilité (1 à 4), vous avez maintenant :
- `DispoX_jour` : Le jour de la semaine
- `DispoX_heure` : L'intervalle horaire de 3 heures
- `DispoX` : **Auto-généré** - Concaténation automatique de `DispoX_jour` + `DispoX_heure`

**Note importante** : Les champs `DispoX` sont maintenant automatiquement remplis par le système en concaténant le jour et l'heure. Vous n'avez plus besoin de les renseigner manuellement.

### Valeurs acceptées

#### Jours (`DispoX_jour`)
- `Lundi`
- `Mardi` 
- `Mercredi`
- `Jeudi`
- `Vendredi`
- `Samedi`
- `Dimanche`

#### Heures (`DispoX_heure`)
Intervalles de 3 heures recommandés :
- `08h-11h` : Matinée
- `11h-14h` : Milieu de journée  
- `14h-17h` : Après-midi
- `17h-20h` : Soirée

### Exemple de requête POST

```json
{
  "NPI": "12345",
  "Experience": "5",
  "Parcours": "Ingénieur informatique",
  "Date_naissance": "1990-05-15",
  "Situation_matrimoniale": "Célibataire",
  "Garant_1": "Jean Dupont",
  "Adresse_garant1": "123 Rue Example",
  "Garant_2": "Marie Martin", 
  "Adresse_garant2": "456 Avenue Test",
  
  // Nouveaux champs structurés (obligatoires)
  "Dispo1_jour": "Lundi",
  "Dispo1_heure": "08h-11h",
  "Dispo2_jour": "Mercredi", 
  "Dispo2_heure": "14h-17h",
  "Dispo3_jour": "Vendredi",
  "Dispo3_heure": "17h-20h",
  "Dispo4_jour": null,
  "Dispo4_heure": null
  
  // Les champs Dispo1, Dispo2, etc. seront automatiquement générés :
  // Dispo1 = "Lundi 08h-11h"
  // Dispo2 = "Mercredi 14h-17h" 
  // Dispo3 = "Vendredi 17h-20h"
  // Dispo4 = null
}
```

### Logique de génération automatique

Les anciens champs `DispoX` sont automatiquement remplis selon ces règles :
- Si `jour` ET `heure` sont renseignés : `"Lundi 08h-11h"`
- Si seulement `jour` est renseigné : `"Lundi"`
- Si seulement `heure` est renseignée : `"08h-11h"`
- Si aucun des deux n'est renseigné : `null`

### Avantages de cette structure

1. **Requêtes facilitées** : Possibilité de filtrer par jour ou par créneau horaire
2. **Validation** : Meilleur contrôle des valeurs acceptées  
3. **Flexibilité** : Combinaisons jour/heure plus précises
4. **Évolutivité** : Facilite l'ajout de nouvelles fonctionnalités de planification
5. **Automatisation** : Plus besoin de formater manuellement les disponibilités
6. **Cohérence** : Format uniforme généré automatiquement

### Rétrocompatibilité

Les anciens champs `DispoX` sont automatiquement générés à partir des nouveaux champs structurés, assurant une parfaite rétrocompatibilité avec les clients existants qui lisent encore ces champs.

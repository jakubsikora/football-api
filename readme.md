## Football API

### Models
#### League 

1. Relations:
  - has many Teams

2. Fields:
  - code
  - name
   
3. Queries:
  - get all leagues /leagues GET
  - get a league /leagues/1 GET
  - create a league /leagues POST
  - update a league /leagues/1 PUT
  - delete a league /leagues/1 DELETE

#### Team 
1. Relations:
  - belongs to League

2. Fields:
  - name
  - attack_home_params
  - defence_home_params
  - attack_away_params
  - defence_away_params 
  - home_advantage
  
3. Queries:
  - get all teams /teams GET ??
  - get a team /teams/1 GET ??
  - get all teams for a league /leagues/1/teams GET
  - get a team for a league /leagues/1/teams/1 GET

#### Match 

1. Relations:
  - has many Scores

2. Fields:

3. Queries:
  - get all matches for a league
  - get all matches for a team

#### Score

1. Relations:
  - belongs to Match

2. Fields:

3. Queries:
  - get score for a match


## Football API

### Source
- `E0,Arsenal,Chelsea,1,0,H` (League,Home Team,Away Team,Home Score,Away Score,Winner)

### Models
#### League 

1. Relations:
  - has many Teams
  - belongs to many Matches

2. Fields:
  - code - E0
  - name - English Premier League
   
3. Queries:
  - get all leagues `/leagues` GET
  - get a league `/leagues/1` GET
  - create a league `/leagues` POST
  - update a league `/leagues/1` PUT
  - delete a league `/leagues/1` DELETE
  - get all teams for a league `/leagues/1/teams`
  - get a team for a league `/leagues/1/teams/1`
  - get all matches for a team in a league `/leagues/1/teams/1/matches`

#### Team 
1. Relations:
  - belongs to many Leagues
  - belongs to many Matches

2. Fields:
  - name - Arsenal
  - attack_home_params - 120 (calculated by a job)
  - defence_home_params - 120 (calculated by a job)
  - attack_away_params - 120 (calculated by a job)
  - defence_away_params - 120 (calculated by a job) 
  - home_advantage - 120 (calculated by a job)
  
3. Queries:
  - get all teams `/teams` GET
  - get a team `/teams/1` GET
  - create a league `/teams` POST
  - update a league `/teams/1` PUT
  - delete a league `/teams/1` DELETE
  - get all matches for a team `/teams/1/matches`

#### Match 

1. Relations:
  - has many home teams
  - has many away teams
  - has many leagues
  
2. Fields:
  - league_id - 1
  - home_team_id - 1
  - away_team_id - 0
  - home_score - 1
  - away_score - 0
  - winner - H (H,A,D)
3. Queries:
  - get all matches `/matches` GET
  - create a matche `/matches` POST
  - update a matche `/matches/1` PUT
  - delete a matche `/matches/1` DELETE



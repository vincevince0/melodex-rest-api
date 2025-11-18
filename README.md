## Endpoints

| URL          | HTTP method | Auth  | JSON Response     | 
| ------------ | ----------- | ----- | -------------     |
| /users/login | POST        |       | user's token      |
| /users       | GET         | Y     | all users         |

| /albums      | GET         |       | all albums        |
| /albums      | POST        | Y     | new album added   |
| /albums      | PATCH       | Y     | edited album      |
| /albums      | DELETE      | Y     | id                |

| /artists     | GET         |       | all artists       |
| /artists     | POST        | Y     | new artist added  |
| /artists     | PATCH       | Y     | edited artist     |
| /artists     | DELETE      | Y     | id                |

| /members     | GET         |       | all members       |
| /members     | POST        | Y     | new members added |
| /members     | PATCH       | Y     | edited member     |
| /members     | DELETE      | Y     | id                |

| /songs       | GET         |       | all songs         |
| /songs       | POST        | Y     | new song added    |
| /songs       | PATCH       | Y     | edited song       |
| /songs       | DELETE      | Y     | id                |
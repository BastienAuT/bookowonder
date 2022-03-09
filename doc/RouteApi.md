# API Routes and Fonctions

## Audio

- route: /api/v1/audio - name="api_v1_audio_browse - methods = {"GET"} - Role : [GUEST] :

```
[
  {
    "id": 1,
    "name": "Lofi pour bien bosser",
    "music": "https:\/\/www.youtube.com\/watch?v=5qap5aO4i9A",
    "image": null,
    "categories": []
  },
  {
    "id": 2,
    "name": "Feu qui fait du bruit",
    "music": "qfqsdfsfsqd",
    "image": null,
    "categories": []
  }
]
```

- route: /api/v1/audio/{id} - name="api_v1_audio_read - methods = {"GET"} - Role : [GUEST]:

```
{
  "id": 2,
  "name": "Feu qui fait du bruit",
  "music": "qfqsdfsfsqd",
  "image": null,
  "categories": []
}
```

- route: /api/v1/audio/category - name="api_v1_audio_category - methods = {"GET"} - Role : [GUEST]:

```
{
    "id": 2,
    "name": "Feu qui fait du bruit",
    "music": "qfqsdfsfsqd",
    "image": null,
    "categories": [
      {
        "id": 1,
        "name": "Science-Fiction",
        "image": null
      },
      {
        "id": 2,
        "name": "Horror",
        "image": null
      }
    ]
  },
  {
    "id": 4,
    "name": "Le bruit de la forêt qui fait du bien",
    "music": "dqsfdsqfsqf",
    "image": null,
    "categories": [
      {
        "id": 1,
        "name": "Science-Fiction",
        "image": null
      },
      {
        "id": 2,
        "name": "Horror",
        "image": null
      },
      {
        "id": 3,
        "name": "Aventure",
        "image": null
      }
    ]
  },

  ```
## Book


- route: /api/v1/book - name="api_v1_book_browse - methods = {"GET"} - Role : [GUEST]:

```
[
  {
    "id": 1,
    "title": "Dune",
    "synopsis": "Paul Atreides, un jeune homme brillant et doué au destin plus grand que lui-même, doit se rendre sur la planète la plus dangereuse de l'univers afin ",
    "picture": null,
    "epub": "fqzdfsdf",
    "publishedAt": null,
    "createdAt": "2021-12-02T13:26:17+01:00",
    "updatedAt": null,
    "isHome": true,
    "author": {
      "id": 3,
      "firstname": "Frank",
      "lastname": "Herbert"
    },
    "editor": {
      "id": 3,
      "name": "Dune"
    },
    "categories": [
      {
        "id": 1,
        "name": "Science-Fiction"
      },
      {
        "id": 2,
        "name": "Horror"
      }
    ],
    "pinnedpages": [],
    "favorites": [
      {
        "id": 2,
        "isFavorite": true,
        "user": {
          "id": 2,
          "email": "anneline@bookowonder.fr",
          "name": "Anne-Line"
        }
      }
    ]
  },
  {
    "id": 2,
    "title": "La métaphysique des tubes",
    "synopsis": "Dans ce roman, la jeune romancière belge raconte sa vie au Japon de zéro à trois ans. De sa naissance jusqu’à deux ans et demi, Amélie est considérée par tous comme un ",
    "picture": null,
    "epub": "sdqfqsf",
    "publishedAt": null,
    "createdAt": "2021-12-02T13:27:35+01:00",
    "updatedAt": null,
    "isHome": false,
    "author": {
      "id": 2,
      "firstname": "Amélie",
      "lastname": "Nothomb"
    },
    "editor": {
      "id": 2,
      "name": "Pinguin"
    },
    "categories": [
      {
        "id": 2,
        "name": "Horror"
      },
      {
        "id": 3,
        "name": "Aventure"
      }
    ],
    "pinnedpages": [
      {
        "id": 1,
        "page": ""
      }
    ],
    "favorites": [
      {
        "id": 1,
        "isFavorite": true,
        "user": {
          "id": 1,
          "email": "marianne@oclock.io",
          "name": "Marianne"
        }
      },
      {
        "id": 5,
        "isFavorite": true,
        "user": {
          "id": 2,
          "email": "anneline@bookowonder.fr",
          "name": "Anne-Line"
        }
      }
    ]
  }
]
```

- route: /api/v1/book/{id} - name="api_v1_book_read - methods = {"GET"} - Role : [GUEST]:

```
{
  "id": 1,
  "title": "Dune",
  "synopsis": "Paul Atreides, un jeune homme brillant et doué au destin plus grand que lui-même, doit se rendre sur la planète la plus dangereuse de l'univers afin d'assurer l'avenir de ",
  "picture": null,
  "epub": "fqzdfsdf",
  "publishedAt": null,
  "createdAt": "2021-12-02T13:26:17+01:00",
  "updatedAt": null,
  "isHome": true,
  "author": {
    "id": 3,
    "firstname": "Frank",
    "lastname": "Herbert"
  },
  "editor": {
    "id": 3,
    "name": "Dune"
  },
  "categories": [
    {
      "id": 1,
      "name": "Science-Fiction"
    },
    {
      "id": 2,
      "name": "Horror"
    }
  ],
  "recommendations": [
    {
      "id": 1,
      "content": "j'adore",
      "recommendation": true,
      "user": {
        "id": 1,
        "email": "marianne@oclock.io",
        "name": "Marianne"
      }
    }
  ],
  "pinnedpages": [],
  "favorites": [
    {
      "id": 2,
      "isFavorite": true,
      "user": {
        "id": 2,
        "email": "anneline@bookowonder.fr",
        "name": "Anne-Line"
      }
    }
  ]
}
```

- route: /api/v1/book/ishome - name="api_v1_book_ishome- methods = {"GET"} - Role : [GUEST]:

```
La même que pour la route read
```

## Category

- route: /api/v1/category - name="api_v1_category_browse - methods = {"GET"} - Role : [GUEST]:

```
[
  {
    "id": 1,
    "name": "Science-Fiction"
  },
  {
    "id": 2,
    "name": "Horror"
  },
  {
    "id": 3,
    "name": "Aventure"
  },
  {
    "id": 4,
    "name": "Fantasy"
  }
]
```

- route: /api/v1/category/{id} - name="api_v1_category_read - methods = {"GET"} - Role : [GUEST]:

```
{
  "id": 1,
  "name": "Science-Fiction",
  "books": [
    {
      "id": 1,
      "title": "Dune",
      "synopsis": "Paul Atreides, un jeune homme brillant et doué au destin plus grand que lui-même, doit se rendre sur la planète la plus dangereuse de l'univers afin d'assurer l'avenir de sa famille et de son peuple.",
      "picture": null
    }
  ],
  "audio": [
    {
      "id": 4,
      "name": "Le bruit de la forêt qui fait du bien",
      "image": null
    }
  ]
}
```

- route: /api/v1/category/audio/{id} - name="api_v1_category_readAudio - methods = {"GET"} - Role : [GUEST]:

```
{
  "id": 3,
  "name": "Aventure",
  "audio": [
    {
      "id": 1,
      "name": "Lofi pour bien bosser",
      "music": "https:\/\/www.youtube.com\/watch?v=5qap5aO4i9A",
      "image": null
    },
    {
      "id": 4,
      "name": "Le bruit de la forêt qui fait du bien",
      "music": "dqsfdsqfsqf",
      "image": null
    }
  ],
  "image": null
}
```

- route: /api/v1/category/audio - name="api_v1_category_browseAudio - methods = {"GET"} - Role : [GUEST]:

```
[
  {
    "id": 1,
    "name": "Science-Fiction",
    "audio": [
      {
        "id": 2,
        "name": "Feu qui fait du bruit",
        "music": "qfqsdfsfsqd",
        "image": null
      },
      {
        "id": 4,
        "name": "Le bruit de la forêt qui fait du bien",
        "music": "dqsfdsqfsqf",
        "image": null
      },
      {
        "id": 5,
        "name": "Le feu qui crépite",
        "music": "sdfsqfddsq",
        "image": "61adfe9f787f6.jpg"
      }
    ],
    "image": null
  },
  {
    "id": 2,
    "name": "Horror",
    "audio": [
      {
        "id": 2,
        "name": "Feu qui fait du bruit",
        "music": "qfqsdfsfsqd",
        "image": null
      }
    ],
    "image": null
  },
]
```

## Author

- route: /api/v1/author - name="api_v1_author_browse - methods = {"GET"} - Role : [GUEST]:

```
[
  {
    "id": 1,
    "firstname": "Bernard",
    "lastname": "Werber",
    "books": []
  },
  {
    "id": 2,
    "firstname": "Amélie",
    "lastname": "Nothomb",
    "books": [
      {
        "id": 2,
        "title": "La métaphysique des tubes"
      }
    ]
  },
]
```

- route: /api/v1/author/{id} - name="api_v1_author_read - methods = {"GET"} - Role : [GUEST]:

```
[
  {
    "id": 2,
    "firstname": "Amélie",
    "lastname": "Nothomb",
    "books": [
      {
        "id": 2,
        "title": "La métaphysique des tubes"
      }
    ]
  }
]
```

## Editor

- route: /api/v1/editor - name="api_v1_editor_browse - methods = {"GET"} - Role : [GUEST]:

```
[
  {
    "id": 1,
    "name": "Hachette",
    "books": []
  },
  {
    "id": 2,
    "name": "Pinguin",
    "books": [
      {
        "id": 2,
        "title": "La métaphysique des tubes"
      },
      {
        "id": 4,
        "title": "Eragon"
      }
    ]
  },
  {
    "id": 3,
    "name": "Dune",
    "books": [
      {
        "id": 1,
        "title": "Dune"
      }
    ]
  }
]
```

- route: /api/v1/editor/{id} - name="api_v1_editor_read - methods = {"GET"} - Role : [GUEST]:

```
[
  {
    "id": 2,
    "name": "Pinguin",
    "books": [
      {
        "id": 2,
        "title": "La métaphysique des tubes"
      },
      {
        "id": 4,
        "title": "Eragon"
      }
    ]
  }
]
```

## Favorite

- route: /api/v1/favorite - name="api_v1_favorite_browse - methods = {"GET"} - Role : [GUEST]:

```
[
  {
    "id": 1,
    "isFavorite": true,
    "book": {
      "id": 2,
      "title": "La métaphysique des tubes"
    },
    "user": {
      "id": 1,
      "email": "marianne@oclock.io"
    }
  }
]
```

- route: /api/v1/favorite/{id} - name="api_v1_favorite_read - methods = {"GET"} - Role : [ROLE_USER]:

```
[
  {
    "id": 1,
    "isFavorite": true,
    "book": {
      "id": 2,
      "title": "La métaphysique des tubes"
    },
    "user": {
      "id": 1,
      "email": "marianne@oclock.io"
    }
  }
]
```

- route: /api/v1/favorite - name="api_v1_favorite_add - methods = {"POST"} - Role : [ROLE_USER]:

```
[
    {
        "isFavorite":
        "book":
        "user":
    }
]
```

- route: /api/v1/favorite/{id} - name="api_v1_favorite_edit - methods = {"PATCH", "PUT"} - Role : [ROLE_USER]:

```
[
    {
        "isFavorite":
        "book":
        "user":
    }
]
```

- route: /api/v1/favorite/{id} - name="api_v1_favorite_delete - methods = {"DELETE"} - Role : [ROLE_USER]:


## PinnedPage

- route: /api/v1/pinnedpage - name="api_v1_pinnedpage_browse - methods = {"GET"} - Role : [ROLE_ADMIN]:

```
[
  {
    "id": 1,
    "page": "",
    "book": {
      "id": 2,
      "title": "La métaphysique des tubes"
    },
    "user": {
      "id": 1,
      "email": "marianne@oclock.io",
      "name": "Marianne"
    }
  }
]
```

- route: /api/v1/pinnedpage/{id} - name="api_v1_pinnedpage_read - methods = {"GET"} - Role : [ROLE_USER]:

```
[
  {
    "id": 1,
    "page": "",
    "book": {
      "id": 2,
      "title": "La métaphysique des tubes"
    },
    "user": {
      "id": 1,
      "email": "marianne@oclock.io",
      "name": "Marianne"
    }
  }
]
```

- route: /api/v1/pinnedpage - name="api_v1_pinnedpage_add - methods = {"POST"} - Role : [ROLE_USER]:

```
[
    {
        "page":
        "book":
        "user":
    }
]
```


- route: /api/v1/pinnedpage/{id} - name="api_v1_pinnedpage_edit - methods = {"PATCH", "PUT"} - Role : [ROLE_USER]:

```
[
    {
        "page":
        "book":
        "user":
    }
]
```

- route: /api/v1/pinnedpage/{id} - name="api_v1_pinnedpage_delete - methods = {"DELETE"} - Role : [ROLE_USER]:


## Recommendation

- route: /api/v1/recommendation - name="api_v1_recommendation_browse - methods = {"GET"} - Role : [GUEST]:

```
[
  {
    "id": 1,
    "content": "sw<fvsfddsqfsqfd",
    "recommendation": true,
    "book": {
      "id": 1,
      "title": "Dune",
      "picture": null
    },
    "user": {
      "id": 1,
      "email": "marianne@oclock.io",
      "name": "Marianne"
    }
  },
  {
    "id": 2,
    "content": "j'aime beaucoup ce livre",
    "recommendation": true,
    "book": {
      "id": 5,
      "title": "Charlie et la chocolaterie",
      "picture": null
    },
    "user": {
      "id": 2,
      "email": "anneline@bookowonder.fr",
      "name": "Anne-Line"
    }
  }
]
```

- route: /api/v1/recommendation/{id} - name="api_v1_recommendation_read - methods = {"GET"} - Role : [ROLE_USER]:

```
[
  {
    "id": 1,
    "content": "sw<fvsfddsqfsqfd",
    "recommendation": true,
    "book": {
      "id": 1,
      "title": "Dune",
      "picture": null
    },
    "user": {
      "id": 1,
      "email": "marianne@oclock.io",
      "name": "Marianne"
    }
  }
]
```

- route: /api/v1/recommendation- name="api_v1_recommendation_add - methods = {"POST"} - Role : [ROLE_USER]:

```
{
	"content": "test de truc",
	"recommendation": 1,
	"book": 2,
	"user": 3
}
```

- route: /api/v1/recommendation/{id} - name="api_v1_recommendation_edit - methods = {"PATCH", "PUT"} - Role : [ROLE_USER]:

```
{
	"content": "test de truc",
	"recommendation": 1,
	"book": 2,
	"user": 3
}
```

- route: /api/v1/recommendation/{id} - name="api_v1_recommendation_delete - methods = {"DELETE"} - Role : [ROLE_USER]:


## User

- route: /api/v1/user - name="api_v1_user_browse - methods = {"GET"} - Role : [ROLE_ADMIN]:

```
[
  {
    "id": 1,
    "email": "marianne@oclock.io",
    "name": "Marianne",
    "profilePic": null,
    "recommendations": [
      {
        "id": 1,
        "content": "sw<fvsfddsqfsqfd",
        "recommendation": true,
        "book": {
          "id": 1,
          "title": "Dune",
          "picture": null
        }
      }
    ],
    "pinnedpages": [
      {
        "id": 1,
        "page": "",
        "book": {
          "id": 2,
          "title": "La métaphysique des tubes",
          "picture": null
        }
      }
    ],
    "favorites": [
      {
        "id": 1,
        "isFavorite": true,
        "book": {
          "id": 2,
          "title": "La métaphysique des tubes",
          "picture": null
        }
      },
      {
        "id": 4,
        "isFavorite": true,
        "book": {
          "id": 5,
          "title": "Charlie et la chocolaterie",
          "picture": null
        }
      }
    ]
  },
  {
    "id": 2,
    "email": "anneline@bookowonder.fr",
    "name": "Anne-Line",
    "profilePic": null,
    "recommendations": [
      {
        "id": 2,
        "content": "j'aime beaucoup ce livre",
        "recommendation": true,
        "book": {
          "id": 5,
          "title": "Charlie et la chocolaterie",
          "picture": null
        }
      }
    ],
    "pinnedpages": [],
    "favorites": [
      {
        "id": 2,
        "isFavorite": true,
        "book": {
          "id": 1,
          "title": "Dune",
          "picture": null
        }
      },
      {
        "id": 3,
        "isFavorite": true,
        "book": {
          "id": 5,
          "title": "Charlie et la chocolaterie",
          "picture": null
        }
      },
      {
        "id": 5,
        "isFavorite": true,
        "book": {
          "id": 2,
          "title": "La métaphysique des tubes",
          "picture": null
        }
      }
    ]
  }
]
```

- route: /api/v1/user/user - name="api_v1_user_read - methods = {"GET"} - Role : [ROLE_USER]:

```
{
  "id": 2,
  "email": "anneline@bookowonder.fr",
  "name": "Anne-Line",
  "profilePic": null,
  "recommendations": [
    {
      "id": 2,
      "content": "j'aime beaucoup ce livre",
      "recommendation": true,
      "book": {
        "id": 5,
        "title": "Charlie et la chocolaterie",
        "picture": null
      }
    }
  ],
  "pinnedpages": [],
  "favorites": [
    {
      "id": 2,
      "isFavorite": true,
      "book": {
        "id": 1,
        "title": "Dune",
        "picture": null
      }
    },
    {
      "id": 3,
      "isFavorite": true,
      "book": {
        "id": 5,
        "title": "Charlie et la chocolaterie",
        "picture": null
      }
    },
    {
      "id": 5,
      "isFavorite": true,
      "book": {
        "id": 2,
        "title": "La métaphysique des tubes",
        "picture": null
      }
    }
  ]
}
```

- route: /api/v1/user/{id} - name="api_v1_user_edit - methods = {"PATCH", "PUT"} - Role : [ROLE_USER]:

```
{
	"email": "test@testApi.fr",
	"roles": ["ROLE_USER", ""],
	"password": "test",
	"name": "test",
	"profilePic": null
}
```

- route: /api/v1/user/{id} - name="api_v1_user_delete - methods = {"DELETE"} - Role : [ROLE_USER]:


## Register, Login and Account

- route: /api/v1/register - name="api_v1_register - methods = {"POST"} - Role : [GUEST]:

```
{
	"email": "anneline@bookowonder.fr",
	"password": "bookowonder",
	"name": "Anne-Line",
	"profilePic": null
}
```

- route: /api/login_check - methods = {"POST"} - Role : [GUEST]

```
{
	"username": "marianne@oclock.io",	
	"password": "admin"
}
```

- route: /api/v1/user/user - name="api_v1_account - methods = {"GET"} - Role : [ROLE_USER]:

```
{
	"email": "admin@admin.com"
}
```

```
{
  "id": 9,
  "email": "admin@admin.com",
  "name": "admin",
  "profilePic": null,
  "recommendations": [],
  "pinnedpages": [],
  "favorites": []
}
```

## Custom queries

- route: /api/v1/favorite/mostfavorite - name="api_v1_favorite_mostfavorite - methods = {"GET"} - Role : [Guest]:

```
[
  {
    "book": {
      "id": 5,
      "title": "Charlie et la chocolaterie",
      "picture": null
    }
  }
]
```

- route: /api/v1/recommendation/mostrecommendated - name="api_v1_recommendation_mostrecommendated - methods = {"GET"} - Role : [Guest]:

```
[
  {
    "book": {
      "id": 4,
      "title": "Eragon",
      "picture": null
    }
  }
]
```

- route: /api/v1/pinnedpage/mostpinned - name="api_v1_pinnedpage_mostpinned - methods = {"GET"} - Role : [Guest]:

```
[
  {
    "book": {
      "id": 2,
      "title": "La métaphysique des tubes",
      "picture": null
    }
  }
]
```

- route: /api/v1/category/mostread - name="api_v1_category_mostread - methods = {"GET"} - Role : [Guest]:

```
[
  {
    "id": 2,
    "name": "Horror",
    "image": null
  }
]
```
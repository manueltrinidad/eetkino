# Planning

# Routes

## Main Routes

- GET / - Main Page / Index
    - Latest reviews.
    - Search bar.
    - Quick stats.

- GET /stats - Statistics
    - Detailed stats

- GET /search - Search
    - Search by Movie title, director, writer and title of review.

- GET /about - About the Site
    - Random info

## Films

- GET /films/{film} - Show film
    - Show related reviews, names, etc
- POST /films - Create new film (auth)
- PUT /films/{film} - Edit film (auth)
- DELETE /films/{film} - Delete film (auth)

## Reviews

- GET /reviews/{review} - Show review
    - Show the content, film, score, etc...
- POST /reviews - Create new review / film / names (auth)
- PUT /review/{review} - Edit review (auth)
- DELETE /reviews/{review} - Delete review (auth)

## Names (same as Films)

## Users (with Auth management)

## Countries

- POST /countries - Create new country (auth)
- PUT /countries/{country} - Edit country (auth)
- DELETE /countries/{country} - Delete country (auth)
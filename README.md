# PHP-FROM-SCRATCH
A web framework built from scratch in PHP.
This repository serves as a documentation of my learning process in application development using object-oriented programming

## Docs
1. [Part 1: Dependency Injection - The Service Container](docs/part_1.md)
## Development
### via Docker Compose
```
docker-compose build
docker-compose up -d
```

## Usage
### via Docker
```
docker build -t app .
docker run --rm -p 8000:8000 app
```


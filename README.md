# bartosz-lauks-engineering-project
Projekt inżynierski Bartosz Lauks 2022

**Polecenia należy wykonąć w docelowym katalogu aplikacji**

**Aplikacja do uruchomienia wymaga Dockera**

==============================================

**Pierwsze uruchomienie aplikacji**
```
$ make build_dev
$ make start_dev
$ make install
```

**Po uruchomieniu aplikacjia dostepna pod adresem localhost:8083**

**Kolejne uruchomienie aplikacji**
```
$ make build_dev
$ make start_dev
$ make install
```


**Wdrażanie backup z danymi testowymi bez zdjęć**

```
$ cat backup.sql | docker exec -it bartosz-lauks-engineering-project-mysql-dev
/usr/bin/mysql -u root bartosz-lauks-engineering-project_dev
```

**Lista użytkowników w tym backup i ich hasła**
- bartosz.lauks@interia.pl hasło : 123123 -> Super admin.
- bartosz.lauksstu@interia.pl hasło : 123123 -> Dziennikarz.
- bartes121@interia.pl hasło : 123123 -> Marketing.
- cruzon@interia.pl hasło : 123123 -> Specialista danych.
- cruzonek@interia.pl hasło : 123123 -> Zwykły użytkownik.

**Wyłączenie aplikacji**

```
$ make stop
```
==============================================

**Aplikacja używa API poczty Gmail. Należy potwierdzić aplikacjie przez wykorzystywane konto Gmail.**

**Aby zmienić poczte wykorzystywaną przez aplikację należy wykonać polecenia**
```
$ docker exec -it bartosz-lauks-engineering-project-php-dev php bin/console secrets:set MAILER_DNS
gmail+smtp://bartoszlauks%40gmail.com:haslo12345@default | Uwaga jest to przykład !
```

- bartoszlauks%40gmail.com -> przykładowy adres e-mail
- %40 -> to @. Wymagane jest kodowanie znaków specjalnych takich jak małpa w adresie e-mail.
- haslo12345 -> przykładowe hasło

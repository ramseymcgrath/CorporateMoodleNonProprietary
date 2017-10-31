
# NON-Proprietary SYMC-Moodle

## Docker Compose

```bash
$ docker-compose up -d
```

## Persisting your application

For persistence you should mount a volume at the `/moodle` path.
Otherwise every deploy will be fresh

##Browsing

Unless you've altered the IP of your docker host, your container will be at http://192.168.1.100


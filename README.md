# RabbitMqExample
Learn how to use RabbitMq with Symfony3


Symfony configuration:
----------------------
app/config/config.yml:
```
# OldSoundRabbitMq Configuration
old_sound_rabbit_mq:
    connections:
        default:
            host:     'localhost'
            port:     5672
            user:     'guest'
            password: 'guest'
            vhost:    '/'
            lazy:     false
    producers:
        api_call:
            connection:       default
            exchange_options: {name: 'api-call', type: direct}
            queue_options:    {name: 'api_call'}
```
app/config/services.yml in services section:
```
    producer_service:
        class: AppBundle\Services\Producer
        arguments: ["@old_sound_rabbit_mq.api_call_producer"]
```

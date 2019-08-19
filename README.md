# WRabbitC

WRabbitC is in wordpress plugin that allows you to send messages to a RabbitMQ broker,
the development, still in an embryonic state, is used for my internship in order to obtain a degree in computer science from the University of Salerno.
At present, the plugin only allows you to send messages to CloudAMQP.

->in version 0.5 we fixed comunication iusses, now throw shortcode [wrabbitc-sc] you can put in all articles or page the form to send data
->in version 0.6.2 we have added connection page to put your own connection settings

## Getting Started

in src folder u can get source

### Prerequisites

min PHP 5.7
min wordpress 5.2.2

### Installing

to test this plugin just download wrabbitc.zip and upload it in plugin section in your wordpress installation

## Running the tests

i suggest to use wordpress debug, see wordpress codex for more info

## Authors

* **Domenico Pascucci ** - *Initial work* - [Pasmimmo](https://github.com/Pasmimmo)

based on a work of [Jakubkulhan](https://github.com/jakubkulhan/bunny) - *Performant pure-PHP AMQP (RabbitMQ) sync/async (ReactPHP) library* 

See also the list of [contributors](https://github.com/pasmimmo/WRabbitC/blob/master/Contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Special Thanks to: 
[Marco Minucci](https://github.com/Kariamos), for the wise guide, and help with the javascript part
Simona De Vita, my boss who didn't put me in the usual hurry and anxiety

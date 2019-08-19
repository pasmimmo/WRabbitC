# WRabbitC

WRabbitC is a WordPress plugin that allows you to connect wordpress with a **[RabbitMQ](https://www.rabbitmq.com/)** broker, as you will know the potentialities of the **AMQP** protocol are many, in fact it is possible to send and receive messages through multiple languages and plattforms ​​(thanks to the countless libraries).

this plugin aims to integrate the **php-amqplib library** into WordPress with a minimal and immediate interface so as to make the user's work as quick and easy as possible.

`Warning: the work is still in development`

## Version History:

* in version 0.5.0 we have solved the communication problems, now using the shortcode **[wrabbitc-sc]** you can insert in all the articles or pages the form to send the data.
* in version 0.6.2 we added the plug-in settings page, *Connection Settings* where you can easily configure the properties of your connection.

## Getting Started

### Prerequisites
* min PHP 5.7
* min wordpress 5.2.2 installed
* a RabbitMQ Server ( may i suggest CloudAMQP, same as us are using during developing )

#### Installing on WordPress
Simple as usual:
 * install zip using WordPress dedicated menu, or
 * just unzip the folder and place in YourSite/wp-content/plugins/

## A bit of history, 
wrtabbitc was born as part of my internship for a degree in computer science at the University of Salerno, where I studied, after a few nights between me and the computer I decided to try to turn my php code into a draft of plugin that can be integrated into wordpress.

## Authors

* **Domenico Pascucci** - *Initial work* - [Pasmimmo](https://github.com/Pasmimmo)

based on a work of [Jakubkulhan](https://github.com/jakubkulhan/bunny) - *Performant pure-PHP AMQP (RabbitMQ) sync/async (ReactPHP) library* 

## License

This project is licensed under the GNU GPL v3 License - see the [LICENSE.md](LICENSE.md) file for details

## Special Thanks to: 
* [Marco Minucci](https://github.com/Kariamos), for the wise guide, and help with the javascript part.
* [Simona De Vita], my "boss" who didn't put me in the usual hurry and anxiety

## Last Notes:
Thanks for visiting my repo,
if you have any iusses or ideas just pull a request
obviusly any help is wellcome!
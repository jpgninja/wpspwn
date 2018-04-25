# A POC for 'WP Support Plus Responsive Ticket System' WordPress plugin <= 8.0.7 RCE


```
__      ___ __  ___ _ ____      ___ __  
\ \ /\ / / '_ \/ __| '_ \ \ /\ / / '_ \
 \ V  V /| |_) \__ \ |_) \ V  V /| | | |
  \_/\_/ | .__/|___/ .__/ \_/\_/ |_| |_|
         |_|       |_|                  

```

---


Affects ['WP Support Plus Responsive Ticket System' WordPress plugin <= 8.0.7](https://wpvulndb.com/vulnerabilities/8949)

> _"WP Support Plus Responsive Ticket System <= 8.0.7 allows anyone to upload PHP files with extensions like ".phtml", ".php4", ".php5", and so on, all of which are run as if their extension was ".php" on most hosting platforms."_

It's a fairly old vuln, but I've been wanting to start putting together more POC's to better understand the vulnerabilities.

Usage: `php wpspwn.php <target> <payload> <extension>`

* `<target>` WordPress install directory URL
* `<payload>` (optional) PHP Payload
* `<extension>` (optional) File extension. _(Accepts: php, php3, php4, php5, php7, pht, phtml)_

---

Always open to comments, questions, and suggestions. I'm trying to learn.

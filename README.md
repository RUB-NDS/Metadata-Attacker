# Metadata-Attacker

With this small suite of open source pentesting tools you're able to create an image (.jpg),
audio (.mp3) or video (.mp4) file containing your custom metadata or a set of cross-site scripting
vectors to test any webservice against possible XSS vulnerabilities when displaying unfiltered meta data.

![](screenshot.png?raw=true)


## Installation / Usage
First install [docker](https://www.docker.com/products/docker) and [docker-compose](https://docs.docker.com/compose/install/) on your host system.

Now you can simply follow these easy steps:

  1. [Download](https://github.com/RUB-NDS/Metadata-Attacker/archive/master.zip) and unzip this repository (or `git clone` it)
  2. `cd` to the unzipped folder
  3. run `docker-compose up -d`

When finished open your favorite browser and switch to the docker ip or [localhost](http://localhost)

## Credits

  - Image-Attacker developed by __[@mniemietz](https://duckduckgo.com)__
  - Audio-Attacker developed by @derctwr
  - Video-Attacker, project merging and docker containers by @Lednerb

# Metadata-Attacker

[![GitHub release](https://img.shields.io/github/release/RUB-NDS/Metadata-Attacker.svg?style=flat-square)](https://github.com/RUB-NDS/Metadata-Attacker/releases) [![GitHub stars](https://img.shields.io/github/stars/RUB-NDS/Metadata-Attacker.svg?style=social&label=Star)](https://github.com/RUB-NDS/Metadata-Attacker) [![GitHub forks](https://img.shields.io/github/forks/RUB-NDS/Metadata-Attacker.svg?style=social&label=Fork)](https://github.com/RUB-NDS/Metadata-Attacker) [![Docker Stars](https://img.shields.io/docker/stars/lednerb/metadata-attacker.svg?style=flat-square)](https://hub.docker.com/r/lednerb/metadata-attacker/) [![Docker Pulls](https://img.shields.io/docker/pulls/lednerb/metadata-attacker.svg?style=flat-square)](https://hub.docker.com/r/lednerb/metadata-attacker/) [![license](https://img.shields.io/github/license/RUB-NDS/Metadata-Attacker.svg?style=flat-square)](https://github.com/RUB-NDS/Metadata-Attacker/blob/master/LICENSE) [![Open Source Love](https://badges.frapsoft.com/os/v2/open-source.svg?v=103)](https://github.com/RUB-NDS/Metadata-Attacker/) 

With this small suite of open source pentesting tools you're able to create an image (.jpg),
audio (.mp3) or video (.mp4) file containing your custom metadata or a set of cross-site scripting
vectors to test any webservice against possible XSS vulnerabilities when displaying unfiltered meta data.

![](screenshot-tool.png?raw=true)


## Installation / Usage
First install [docker](https://www.docker.com/products/docker) on your host system.

Now you can simply run the following command:

`sudo docker run -p 80:80 --rm lednerb/metadata-attacker`

When finished open your favorite browser and switch to the docker ip or [http://localhost](http://localhost)

## Credits

  - Image-Attacker developed by __[@mniemietz](https://github.com/mniemietz)__
  - Audio-Attacker developed by __[@derctwr](https://github.com/derctwr)__
  - Video-Attacker, project merging and docker containers by __[@Lednerb](https://github.com/Lednerb)__

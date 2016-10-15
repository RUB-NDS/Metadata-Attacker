# Metadata-Attacker

With this small suite of open source pentesting tools you're able to create an image (.jpg),
audio (.mp3) or video (.mp4) file containing your custom metadata or a set of cross-site scripting
vectors to test any webservice against possible XSS vulnerabilities when displaying unfiltered meta data.

![](screenshot-tool.png?raw=true)


## Installation / Usage
First install [docker](https://www.docker.com/products/docker) on your host system.

Now you can simply run the following command:

`docker run -p 80:80 --name metadta-attacker --rm lednerb/metadata-attacker`

When finished open your favorite browser and switch to the docker ip or [http://localhost](http://localhost)

## Credits

  - Image-Attacker developed by __[@mniemietz](https://github.com/mniemietz)__
  - Audio-Attacker developed by __[@derctwr](https://github.com/derctwr)__
  - Video-Attacker, project merging and docker containers by __[@Lednerb](https://github.com/Lednerb)__

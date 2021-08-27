# Browser Tests

## Using docker

Run following command before browser tests:
```
docker run -d -p 4444:4444 selenium/standalone-chrome:3.141.59-zirconium
```

## Local

### Download chrome driver

Go to https://chromedriver.chromium.org/ and download available version, or run commands:

```
wget https://chromedriver.storage.googleapis.com/92.0.4515.107/chromedriver_linux64.zip
unzip chromedriver_linux64.zip
cp chromedriver /usr/local/bin/chromedriver
```


### Download selenium

Go to https://www.selenium.dev/downloads/

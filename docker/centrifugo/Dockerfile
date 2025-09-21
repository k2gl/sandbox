FROM centrifugo/centrifugo:v6 as centrifugo_base

FROM centrifugo_base AS centrifugo_dev

COPY ./docker/centrifugo/config/config-test.json /centrifugo/config.json

CMD ["centrifugo", "-c",  "config.json"]

FROM debian:latest

ARG ROOT_SSH_PASSWORD=password

RUN apt-get -y update && apt-get -y install \
    ssh \
    curl \
    wget \
    rsync \
    tar \
    python \
    sudo \
    && systemctl enable ssh \
    && sed -i "s/.*PermitRootLogin prohibit-password.*/PermitRootLogin yes/g" /etc/ssh/sshd_config \
    && apt-get clean

RUN yes $ROOT_SSH_PASSWORD | passwd

COPY entrypoint /entrypoint

CMD ["/entrypoint"]

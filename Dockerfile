FROM laravelsail/php82-composer:latest

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    python3 python3-pip libgl1 \
    python3-opencv python3-skimage python3-numpy \
    supervisor nginx-full \
&& apt-get clean && rm -rf /var/lib/apt/lists/*
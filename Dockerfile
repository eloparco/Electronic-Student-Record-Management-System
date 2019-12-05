FROM se2polito/team-f:version1.0

COPY setup.sh setup.sh
RUN chmod -R 777 setup.sh
ENTRYPOINT service mysql start && ./setup.sh

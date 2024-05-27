FROM couchbase:community

COPY init.sh /init.sh

RUN chmod +x /init.sh

ENTRYPOINT ["/init.sh"]

# CMD ["couchbase-server"]
# calculadora-mineria-backend



# In all environments, the following files are loaded if they exist,
# the latter taking precedence over the former:
#
#  * .env                contains default values for the environment variables needed by the app
#  * .env.local          uncommitted file with local overrides
#  * .env.$APP_ENV       committed environment-specific defaults
#  * .env.$APP_ENV.local uncommitted environment-specific overrides
#
# Real environment variables win over .env files.
#
# DO NOT DEFINE PRODUCTION SECRETS IN THIS FILE NOR IN ANY OTHER COMMITTED FILES.
#
# Run "composer dump-env prod" to compile .env files for production use (requires symfony/flex >=1.2).
# https://symfony.com/doc/current/best_practices.html#use-environment-variables-for-infrastructure-configuration

###> symfony/framework-bundle ###
APP_ENV=dev
APP_SECRET=643acec2c0b8a762ed5cf0e0acd90a5e
APP_URL=http://localhost:8000/
###< symfony/framework-bundle ###

###> symfony/mailer ###
# MAILER_DSN=smtp://localhost
###< symfony/mailer ###

###> doctrine/doctrine-bundle ###
# Format described at https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url
# IMPORTANT: You MUST configure your server version, either here or in config/packages/doctrine.yaml
#
# DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
# DATABASE_URL="mysql://root:1234@127.0.0.1:3306/calculator?serverVersion=8.0.28&charset=utf8mb4"
#DATABASE_URL="mysql://symfony:ChangeMe@127.0.0.1:5432/app?serverVersion=13&charset=utf8"

DB_USERNAME=root
DB_PASSWORD=1234
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=calculator
DB_VERSION=8.0
# DATABASE_URL="mysql://${DB_USERNAME}:${DB_PASSWORD}@${DB_HOST}:${DB_PORT}/${DB_DATABASE}?serverVersion=${DB_VERSION}"
DATABASE_URL="mysql://root:1234@127.0.0.1:3306/calculator?serverVersion=8&charset=utf8"

###< doctrine/doctrine-bundle ###

###> nelmio/cors-bundle ###
CORS_ALLOW_ORIGIN='^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$'
###< nelmio/cors-bundle ###

###> lexik/jwt-authentication-bundle ###
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=calculatorapp
# JWT_PASSPHRASE=1878baf84f1c96cfc9c0117e1c5fbf98
###< lexik/jwt-authentication-bundle ###

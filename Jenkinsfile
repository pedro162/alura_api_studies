stage('Build') {
    steps {
        script {
            sh """
                ${DOCKER_COMPOSE} build
            """
        }
    }
}

stage('Run Tests') {
    steps {
        script {
            sh """
                ${DOCKER_COMPOSE} run --rm app php artisan test
            """
        }
    }
}

stage('Deploy') {
    steps {
        script {
            sh """
                ${DOCKER_COMPOSE} up -d
            """
        }
    }
}

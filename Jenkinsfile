#!groovy

pipeline {
  agent any

  stages {
    stage('Checkout') {
      steps {
        isUnix()
      }
    }

    stage('Build (Test)') {
      steps {
        sh "cp ${env.WORKSPACE}/.env.dist ${env.WORKSPACE}/.env"
        sh "mkdir -p ${env.WORKSPACE}/reports"
        sh "composer install --no-interaction"
      }
    }

    stage('Validate') {
      steps {
        parallel(
          "CS-Fix": {
            sh "php ${env.COMPOSER_BIN}/php-cs-fixer fix ${env.WORKSPACE}/app --no-interaction --dry-run --diff -vvv"
          },
          "Code Sniffer": {
            sh "php ${env.COMPOSER_BIN}/phpcs ${env.WORKSPACE}/app --report=junit --report-file=${env.WORKSPACE}/reports/phpcs.xml --config-set ignore_warnings_on_exit 1"
            checkstyle pattern: "reports/phpcs.xml"
          },
          "Mess Detect": {
            sh "php ${env.COMPOSER_BIN}/phpmd ${env.WORKSPACE}/app xml cleancode,codesize,controversial,design,naming,unusedcode --reportfile ${env.WORKSPACE}/reports/mess.xml --suffixes php --ignore-violations-on-exit"
            pmd pattern: "reports/mess.xml"
          },
          "Copy-Paste Detect": {
            sh "php ${env.COMPOSER_BIN}/phpcpd ${env.WORKSPACE}/app --log-pmd=${env.WORKSPACE}/reports/copypaste.xml"
            dry pattern: "reports/copypaste.xml"
          }
        )
      }
    }

    stage('Test (E2E)') {
      steps {
        sh "php ${env.WORKSPACE}/vendor/bin/phpunit --config ${env.WORKSPACE}/phpunit.xml --log-junit ${env.WORKSPACE}/reports/phpunit.xml"
        junit allowEmptyResults: true, testResults: "reports/phpunit.xml"
      }
    }

    stage('Build (Deploy)') {
      steps {
        sh "rm -rf ${env.WORKSPACE}/vendor ${env.WORKSPACE}/var/cache/*"
        sh "composer install --no-interaction --optimize-autoloader --no-dev"
        sh "npm install"
        sh "npm run build"
        archiveArtifacts artifacts: 'bin/**', onlyIfSuccessful: true, fingerprint: true
        archiveArtifacts artifacts: 'config/**', onlyIfSuccessful: true, fingerprint: true
        archiveArtifacts artifacts: 'public/**', onlyIfSuccessful: true, fingerprint: true
        archiveArtifacts artifacts: 'src/**', onlyIfSuccessful: true, fingerprint: true
        archiveArtifacts artifacts: 'templates/**', onlyIfSuccessful: true, fingerprint: true
        archiveArtifacts artifacts: 'translations/**', onlyIfSuccessful: true, fingerprint: true
        archiveArtifacts artifacts: 'var/**', onlyIfSuccessful: true, fingerprint: true
        archiveArtifacts artifacts: 'vendor/**', onlyIfSuccessful: true, fingerprint: true
      }
    }

    stage('Deploy') {
      steps {
        deploy()
      }
    }
  }

  post {
    failure {
      sendNotification('failure')
    }
    success {
      sendNotification('success')
    }
  }

  environment {
    COMPOSER_HOME = "${env.JENKINS_HOME}/.composer"
    COMPOSER_BIN = "${env.COMPOSER_HOME}/vendor/bin"
  }

  options {
    timeout time: 1, unit: 'HOURS'
    buildDiscarder(logRotator(daysToKeepStr: '3', numToKeepStr: '5'))
  }
}

def deploy() {
  if("${env.BRANCH_NAME}" == 'master') {
    echo "Deploying to production server"
  } else if("${env.BRANCH_NAME}" == 'develop') {
    echo "Deploying to staging server"
  } else {
    echo "Skip deploying"
  }
}

def getArtifactsPath() {
    def JOB = "${env.JOB_NAME}".split("/")
    return "${env.JENKINS_HOME}/jobs/${JOB[0]}/branches/${env.BRANCH_NAME}/builds/${env.BUILD_NUMBER}/archive/*"
}

def sendNotification(status) {
  if(status == 'success') {
    slackSend([
      message: "Build success - ${env.JOB_NAME} (<${env.BUILD_URL}|Open>)",
      color: "#5cb85c",
      channel: "",
      teamDomain: "",
      token: ""
    ])
  } else if(status == 'failure') {
    slackSend([
      message: "Build failed - ${env.JOB_NAME} (<${env.BUILD_URL}|Open>)",
      color: "#d9534f",
      channel: "",
      teamDomain: "",
      token: ""
    ])
  }
}
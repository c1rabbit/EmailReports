<?php
require_once '../vendor/autoload.php';
class MyConfigurator implements LoggerConfigurator {

  public function configure(LoggerHierarchy $hierarchy, $input = null) {

      // Use a different layout for the next appender
      $layout = new LoggerLayoutPattern();
      $layout->setConversionPattern("%date{Y-m-d H:i:s} [%logger] %-5level - %msg%newline");
      $layout->activateOptions();

      // Create an appender which echoes log events, using a custom layout
      // and with the threshold set to INFO
      $appEcho = new LoggerAppenderEcho('myConsoleAppender');
      //$appEcho->setLayout($layout);
      $appEcho->setThreshold('debug');
      $appEcho->activateOptions();

      // Create an appender which logs to file
      $appFile = new LoggerAppenderFile('myFileAppender');
      $appFile->setFile('../myLog.log');
      $appFile->setLayout($layout);
      $appFile->setAppend(true);
      $appFile->setThreshold('info');
      $appFile->activateOptions();

      // Add both appenders to the root logger
      $root = $hierarchy->getRootLogger();
      $root->addAppender($appFile);
      $root->addAppender($appEcho);
  }

}
Logger::configure(null, 'MyConfigurator');

?>
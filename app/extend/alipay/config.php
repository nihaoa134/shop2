<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016092500596510",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEpAIBAAKCAQEAohho/tZJ/cc2hSYnMgNUgnRYOoLS1397EJSxmW0ANtS1+n0P8t6jrDUGrdsHeEGdtH39OCPgN/nBo6AhoQlKBsHPBq5ZEtQoX7TxpGSAM43mmPnYDALF+sjze7zbIKyYgcaepsmX8r0lfjioJvTSrNkoze67TX20dbF2zT49gabCr1jFRfhChm45WFlxTK90uAHCN9YHWy8ixvJ90lTIJw65SGhklbA8DL7pAMUbRoWey7J6+QfWT9MU49zUrysLHl+O++G6IovLPR/bugrIwjjkM+kkKdXgYdrKp3EN4kZKGh8YcJsEnFP0WWJiW/ReP9hh4G8jLbshgBAFhWS0TwIDAQABAoIBACZfFOvOmnFi6TsXzwt90lGXbRNcyMCOwvkn2erx7K0OKY4EcPQTVDd9zfj18oy7K7QAZyMVCwz1KKutSoiuhEGZO4LfXuKgKnaNhO5fhCGwI7hu3H/rYCZ/z3OpP046zVdbR09ARaIGuItqqhOevQiB17D4JIqxiTibK/5mD3VTPhorg6gFZWu01vXcKNalKzA6PRNqpuzGTqsCI/Q1EptaejbwVZ67G7HJnuP02iADSjeKT/ONEUUbTJhvIHX25DOGxvWAI3WfzHloNgO0tyNtcXhLqaLXs3wlohH+vl1SvMvFeasW+kcv+MHAguZlkkrT17jxM0GwJx/M8ohfbHECgYEA09Z25Cqd0SYeWYhTD5sD3gknpVxN+HVit54TohDxbh50ybNEBl0iWjTqXXJJ66ZxUXcCsGQcliV04HmxY9nYxeNE+3skwckH0e41C+5AkP/m98PXqAKJOvoVbT/WzKtC4V7Q0tE7qYiDAmU9q/wvvPD4dBGLqVd7lf9OD+LbH/0CgYEAw+NAXkKChF4QRH3UkcPrpivPCQ/P1TgFMScTN6lYahlIXGa7R26AT6kTu9ApCqX2oQtYtM1m/wx9ywJhrpiKoskyOx4kSPIQqWOyjVSbJHNFATvOhi2MPIatAWZmqn3Z9MCuQJjLWafT+3aD4XXWxSRl+c7flA8neQW5LORpOTsCgYB0LhAgjPrm5RgKFIkxatwRH0Y+G8Sren28pJax8MbolQ2KPaYWM2gOvyy2OWMvOaa2fiXcZduDwWE7Z6KRV73asg14Ow5qtX1zdkhjlbSVkbOzuRYCj/mBffzYYQXGVDsm7WBr7tLg5PytCKdtNq9b2XD5/1Fwe4lNN6sxbUKuZQKBgQCjOvQBV+TQjl155WzDxoHQJ4NPJsjmANd6vPfrkwbk6op8zPJUNMVhHCAgifYZNHDOg9j4WIzyDSOpjiN9zQkBWyyrTJOp4WR28mfwE0dwWUlwHLkc4EmSihsSJpV4joSXyhOqKmiRHiOr0HdW4c4E2y7KulNeWj5nP5ityuvPzwKBgQDH6WhZDZBqYA5qmgbs4zE9tyJFYpRZ3fWTv9o/94hYrHuZURv5zPE5vbi0gIhG96rmMGCTIbCfZfn7azF36q2DL+0yvjHWntZU6Tvc37F54UrJTh54csfuZcd3eWhmEgJVJuBn5VL+q9YugacoOrvupRH2CU9wxoLQnNSA63V+og==",
		
		//异步通知地址
		'notify_url' => "http://unique.wanxiaoyu.cn/notify",
		
		//同步跳转
		'return_url' => "http://unique.wanxiaoyu.cn/sync",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAohho/tZJ/cc2hSYnMgNUgnRYOoLS1397EJSxmW0ANtS1+n0P8t6jrDUGrdsHeEGdtH39OCPgN/nBo6AhoQlKBsHPBq5ZEtQoX7TxpGSAM43mmPnYDALF+sjze7zbIKyYgcaepsmX8r0lfjioJvTSrNkoze67TX20dbF2zT49gabCr1jFRfhChm45WFlxTK90uAHCN9YHWy8ixvJ90lTIJw65SGhklbA8DL7pAMUbRoWey7J6+QfWT9MU49zUrysLHl+O++G6IovLPR/bugrIwjjkM+kkKdXgYdrKp3EN4kZKGh8YcJsEnFP0WWJiW/ReP9hh4G8jLbshgBAFhWS0TwIDAQAB",
		
	
);

return $config;
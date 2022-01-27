<?php

namespace PHPFUI\PayPal;

class Express extends \PHPFUI\HTML5Element
	{
	use \PHPFUI\Traits\Page;

	private ?string $errorUrl = null;

	private ?string $executeUrl = null;

	private ?string $logUrl = null;

	private ?string $paymentUrl = null;

	private \PHPFUI\Interfaces\Page $page;

	private string $clientId;

	private array $styles = [
		'layout' => 'vertical',
		'size' => 'medium',
		'shape' => 'pill',
		'color' => 'gold',
	];

	private string $type = 'sandbox';

	public function __construct(\PHPFUI\Interfaces\Page $page, string $clientId)
		{
		parent::__construct('div');
		$this->page = $page;
		$this->clientId = $clientId;
		$this->page->addHeadScript('https://www.paypalobjects.com/api/checkout.js');
		}

	public function addStyle(string $style, $value = null) : self
		{
		if (null === $value)
			{
			unset($this->styles[$style]);
			}
		else
			{
			$this->styles[$style] = $value;
			}

		return $this;
		}

	public function getStyle() : array
		{
		return $this->styles;
		}

	public function setErrorUrl(string $url) : self
		{
		$this->errorUrl = $url;

		return $this;
		}

	public function setExecuteUrl(string $url) : self
		{
		$this->executeUrl = $url;

		return $this;
		}

	public function setLogUrl(string $url) : self
		{
		$this->logUrl = $url;

		return $this;
		}

	public function setPaymentUrl(string $url) : self
		{
		$this->paymentUrl = $url;

		return $this;
		}

	public function setStyles(array $styles) : self
		{
		$this->styles = $styles;

		return $this;
		}

	public function setType(string $type = 'sandbox') : self
		{
		$this->type = $type;

		return $this;
		}

	protected function getStart() : string
		{
		if (! $this->paymentUrl || ! $this->executeUrl)
			{
			throw new \Exception(__CLASS__ . ' payment and / or execute urls are not set');
			}

		$js = "paypal.Button.render({env:'{$this->type}',commit:true,style:" . \PHPFUI\TextHelper::arrayToJS($this->styles, "'") .
			",client:{{$this->type}:'{$this->clientId}'}," .
			"payment:function(data,actions){return paypal.request.post('{$this->paymentUrl}').then(function(data){return data.id;});}," .
			"onAuthorize:function(data,actions){return paypal.request.post('{$this->executeUrl}',{paymentId:data.paymentID,payerId:data.payerID})." .
			'then(function(data){window.location.href=data.url;})},' .
			'onCancel:function(data,actions){window.location.href=data.cancelUrl;},';

		if ($this->logUrl || $this->errorUrl)
			{
			$js .= 'onError:function(err){';

			if ($this->logUrl)
				{
				$js .= '$.ajax("' . $this->logUrl . '",err);';
				}

			if ($this->errorUrl)
				{
				$js .= 'window.location.href = "' . $this->errorUrl . '";';
				}

			$js .= '}';
			}

		$js .= '},"#' . $this->getId() . '");';
		$this->page->addJavaScript($js);

		return parent::getStart();
		}
	}

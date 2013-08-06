<?php

class Twitter extends TwitterOAuth {
	
	public function setAccessToken($token = null, $secret = null)
	{
		$this->token = null;
		
		// token is provided as an array => secret is within array
		if (!empty($token['oauth_token']) && !empty($token['oauth_token_secret']))
			return $this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']);
		
		// token and secret given as args
		if (!empty($token) && !empty($secret)) 
			$this->token = new OAuthConsumer($token, $secret);
	}
	
	function getAccessToken($oauth_verifier)
	{
		if (!$this->token) return null;
		$parameters = array();
		$parameters['oauth_verifier'] = $oauth_verifier;
		$request = $this->oAuthRequest($this->accessTokenURL(), 'GET', $parameters);
		$token = OAuthUtil::parse_parameters($request);
		if (empty($token['oauth_token_secret'])) return null;
		$this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']);
		return $token;
	}
	
}

?>
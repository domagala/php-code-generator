<?php
namespace gossi\codegen\model\parts;

use gossi\codegen\model\PhpParameter;

trait ParametersTrait {

	/**
	 *
	 * @var PhpParameter[]
	 */
	private $parameters = [];

	/**
	 * Sets a collection of parameters
	 * 
	 * @param PhpParameter[] $parameters
	 * @return $this
	 */
	public function setParameters(array $parameters) {
		$this->parameters = array_values($parameters);

		return $this;
	}

	/**
	 * Adds a parameter
	 * 
	 * @param PhpParameter $parameter
	 * @return $this
	 */
	public function addParameter(PhpParameter $parameter) {
		$this->parameters[count($this->parameters)] = $parameter;

		return $this;
	}
	
	/**
	 * Checks whether a parameter exists
	 * 
	 * @param string $name parameter name
	 * @return boolean `true` if a parameter exists and `false` if not
	 */
	public function hasParameter($name) {
		foreach ($this->parameters as $parameter) {
			if ($parameter->getName() === $name) {
				return true;
			}
		}
		return false;
	}

	/**
	 * A quick way to add a parameter which is created from the given parameters 
	 * 
	 * @param string      $name
	 * @param null|string $type
	 * @param mixed       $defaultValue omit the argument to define no default value
	 *
	 * @return $this
	 */
	public function addSimpleParameter($name, $type = null, $defaultValue = null) {
		$parameter = new PhpParameter($name);
		$parameter->setType($type);

		if (2 < func_num_args()) {
			$parameter->setDefaultValue($defaultValue);
		}

		$this->addParameter($parameter);
		return $this;
	}

	/**
	 * A quick way to add a parameter with description which is created from the given parameters
	 * 
	 * @param string      $name
	 * @param null|string $type
	 * @param null|string $typeDescription
	 * @param mixed       $defaultValue omit the argument to define no default value
	 *
	 * @return $this
	 */
	public function addSimpleDescParameter($name, $type = null, $typeDescription = null, $defaultValue = null) {
		$parameter = new PhpParameter($name);
		$parameter->setType($type);
		$parameter->setTypeDescription($typeDescription);

		if (3 < func_num_args() == 3) {
			$parameter->setDefaultValue($defaultValue);
		}

		$this->addParameter($parameter);
		return $this;
	}

	/**
	 * Returns a parameter by index or name
	 * 
	 * @param string|integer $nameOrIndex
	 * @return PhpParameter
	 */
	public function getParameter($nameOrIndex) {
		if (is_int($nameOrIndex)) {
			if (!isset($this->parameters[$nameOrIndex])) {
				throw new \InvalidArgumentException(sprintf('There is no parameter at position %d.', $nameOrIndex));
			}

			return $this->parameters[$nameOrIndex];
		}

		foreach ($this->parameters as $param) {
			assert($param instanceof PhpParameter);

			if ($param->getName() === $nameOrIndex) {
				return $param;
			}
		}

		throw new \InvalidArgumentException(sprintf('There is no parameter named "%s".', $nameOrIndex));
	}

	/**
	 * Replaces a parameter at a given position
	 * 
	 * @param int $position
	 * @param PhpParameter $parameter
	 * @throws \InvalidArgumentException
	 * @return $this
	 */
	public function replaceParameter($position, PhpParameter $parameter) {
		if ($position < 0 || $position > count($this->parameters)) {
			throw new \InvalidArgumentException(sprintf('The position must be in the range [0, %d].', count($this->parameters)));
		}
		$this->parameters[$position] = $parameter;

		return $this;
	}

	/**
	 * Remove a parameter at a given position
	 * 
	 * @param integer $position
	 * @return $this
	 */
	public function removeParameter($position) {
		if (!isset($this->parameters[$position])) {
			throw new \InvalidArgumentException(sprintf('There is no parameter at position "%d" does not exist.', $position));
		}
		unset($this->parameters[$position]);
		$this->parameters = array_values($this->parameters);

		return $this;
	}

	/**
	 * Returns a collection of parameters
	 * 
	 * @return PhpParameter[]
	 */
	public function getParameters() {
		return $this->parameters;
	}
}
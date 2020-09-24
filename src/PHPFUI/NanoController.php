<?php

namespace PHPFUI;

/**
 * # NanoController - A KISS controller built for speed
 * **NanoController** is an extremely simple and fast controller that uses the URI and not a routing table.
 * ### Why NanoController?
 * Traditional MVC frameworks use a routing table, which ends up being difficult to maintain and not obvious as to what the resulting URI is or what classes end up being invoked.  Routing tables are a level of indirection that are really not needed for projects that define their own pathing, which is basically any business app behind a sign in page. In addition to requiring a complex routing table, the routing table takes up memory and execution time to resolve the route. **NanoController** has virtually no memory footprint and a very  fast lookup algorithm. Reduced memory usage and fast execution times are especially important with an interpreted language such as PHP. Time and memory are cumulative, and best avoided where ever possible.
 * ### KISS - Keep It Simple Stupid
 * The **NanoController** maps namespaces, classes and methods directly to the URI and dispenses with a routing table.  The result is an easy to understand namespace and classs structure that exactly matches your URI. The URI tells you exactly where the class lives, and the class tells you the exact URI. No need to check a routing table to know what is invoked when.
 * ### Naming Conventions
 * **NanoController** follows standard naming conventions to figure out what namespace, class and method to call.  Namespaces and classes should use *studly case*, capitalized first letter and capitalized letter of every word. Methods should follow *snake case*, where the first letter is lowercase, with subsequent word's first letter upper cased, although this is not required, as PHP features case insensitive method names (unfortunately). **NanoController** uses the first lower case segment as the method name. The preceding parts form the namespace and class.
 * ### Example
 * With a URI of /Account/User/edit/4321, the method edit would be invoked with a parameter of 4321 from the class User in the namespace App\Account.  You can specify any root namespace, but the default is App.
 * ### Parameters
 * You can pass parameters with URI segments past the first lower case segment (which is the method name to call in the class) by simply specifying additional segments.  **NanoController** uses method parameter types to cast the  parameters to the right types.  You can specify any scalar (**bool, int, float, string**), and **NanoController** will cast it to the correct type.  If your parameter type is a class, **NanoController** will instantiate the class and pass the constuctor a string representation of the URI part. If you specify **array** as the type, **NanoController** will pass all subsequent URI parts as the array. No other parameters will be passed after an array parameter.
 * ### Method Call
 * **NanoController** will instantiate the class and call the specified method and pass any appropriate parameters.  The run method returns the instantiated class with the specified method run. It is your job to deal with the object after that. Generally you would just call its output function (__toString normally) and return a completed page, but it is up to you.
 * ### Landing Pages
 * If a valid method is not found, but the class is, **NanoController** will attempt to call the default missing method if explicitly defined. This allows for a default landing page if a method is not called.  If a default method is not specified, **NanoController** continues up the URI tree looking for a default method.  If no class and default method are found, then the missing page is returned.
 * ### Missing Class
 * Users are prone to not typing in URIs exactly, so if **NanoController** can not find a class and method to instantiate, it will return a missing class of **App\Missing**, which can be overridden if needed.
 */
class NanoController
	{

	private $rootNamespace;
	private $get;
	private $post;
	private $files;
	private $missingClass;
	private $missingMethod;
	private $errors = [];
	private $invokedPath = '';

	public function __construct()
		{
		// initialize all the parameters to defaults
		$reflection = new \ReflectionClass($this);
		$methods = $reflection->getMethods();

		foreach ($methods as $method)
			{
			$name = $method->name;

			if (0 === strpos($name, 'set'))
				{
				// call the set function with default parameters
				$this->{$name}();
				}
			}

		if (isset($_GET))
			{
			$this->get = $_GET;
			}
		if (isset($_POST))
			{
			$this->post = $_POST;
			}
		if (isset($_FILES))
			{
			$this->files = $_FILES;
			}
		}

	/**
	 * Returns the URI path that was finally loaded
	 */
	public function getInvokedPath() : string
		{
		$invokedPath = str_replace($this->rootNamespace . '\\', '', $this->invokedPath);

		return str_replace('\\', '/', $invokedPath);
		}

	/**
	 * Namespace prefix for your classes so they don't have to be in the root namespace
	 */
	public function setRootNamespace(string $namespace = 'App') : self
		{
		$this->rootNamespace = $namespace;

		return $this;
		}

	/**
	 * Run the controller and execute the class and method indicated by the URI
	 *
	 * @return object instantiated class with the appropriate method called
	 */
	public function run() : object
		{
		/**
		 * Iterate through uri looking for a lowercase letter
		 * Lower case letter indicates a method name
		 * look at previous
		 */
		$urlParts = parse_url($_SERVER['REQUEST_URI']);
		$parts = explode('/', $urlParts['path']);
		array_shift($parts);
		$class = explode('\\', $this->rootNamespace);
		foreach ($parts as $index => $method)
			{
			if (strlen($method) && ctype_lower($method[0]))
				{
				$classObject = $this->invokeClassMethod($class, $method, $parts, $index);
				if ($classObject)
					{
					return $classObject;
					}
				else
					{
					return $this->punt($class);
					}
				}
			elseif (! ctype_alpha($parts[0]))
				{
				// not alpha start, need to punt
				return $this->punt($class);
				}
			// add the part the class
			$class[] = $method;
			}

		return $this->punt($class);
		}

	/**
	 * Test if the class and method exists, and if so, return the instantiated class with the method called
	 *
	 * @return null|object null value indicates class::method was not found
	 */
	private function invokeClassMethod(array $class, string $method, array $parts = [], int $index = 0) : ?object
		{
		$className = implode('\\', $class);
		// if we are at the rool namespace, we are done
		if ($className == $this->rootNamespace)
			{
			return null;
			}

		// should have method name and class, try to invoke
		if (! class_exists($className))
			{
			$this->errors['Class ' . $className . ' does not exist'] = true;

			return null;
			}

		if (! method_exists($className, $method))
			{
			$this->errors['Class Method ' . $className . '::' . $method . ' does not exist'] = true;

			return null;
			}

		$classObject = new $className($this);
		$this->invokedPath = $className . '\\' . $method;
		$reflection = new \ReflectionClass($classObject);
		$reflectionMethod = $reflection->getMethod($method);
		$args = ($index + 1) < count($parts) ? array_slice($parts, $index + 1) : [];
		$numberArgs = count($args);
		$argNumber = 0;
		foreach ($reflectionMethod->getParameters() as $parameter)
			{
			if ($argNumber >= $numberArgs)
				{
				break;
				}
			$arg = $args[$argNumber];
			if ($parameter->hasType())
				{
				$type = $parameter->getType();
				$parameterType = $type->getName();
				if ($type->isBuiltIn())
					{
					switch ($type->getName())
						{
						case 'array': // remaining arguments are put into this parameter and processing stops
							$arg = array_slice($args, $argNumber);
							$args = array_slice($args, 0, $argNumber);
							$argNumber = $numberArgs;
							break;
						case 'bool':
							$arg = (bool)$arg;
							break;
						case 'int':
							$arg = (int)$arg;
							break;
						case 'float':
							$arg = (float)$arg;
							break;
						}
					}
				else
					{
					$arg = new $parameterType($arg);
					}
				}
			$args[$argNumber++] = $arg;
			}
		$reflectionMethod->invokeArgs($classObject, $args);

		return $classObject;
		}

	/**
	 * We can't find a Class\Method pair, so just find a class and check if it has a landing page if defined, else, just construct the class and return.
	 *
	 * @return object will return the missing class if the missing method can't be loaded
	 */
	private function punt(array $classParts) : object
		{
		while (count($classParts))
			{
			$className = implode('\\', $classParts);
			// if we are at the rool namespace, we are done
			if ($className == $this->rootNamespace)
				{
				break;
				}

			if ($this->missingMethod)
				{
				$classObject = $this->invokeClassMethod($classParts, $this->missingMethod);
				if ($classObject)
					{
					return $classObject;
					}
				}
			array_pop($classParts);
			}

		return new $this->missingClass($this);
		}

	/**
	 * If no class is found in the URI, return an instance of this class.
	 */
	public function setMissingClass(string $missingClass = 'App\\Missing') : self
		{
		$this->missingClass = $missingClass;

		return $this;
		}

	/**
	 * If a class is found, but a method is not, then return the missing method. If no missing method is defined, then the missing class constructor is called
	 */
	public function setMissingMethod(string $missingMethod = '') : self
		{
		$this->missingMethod = $missingMethod;

		return $this;
		}

	public function getGet() : array
		{
		return $this->get;
		}

	public function setGet(array $get = []) : self
		{
		$this->get = $get;

		return $this;
		}

	public function getPost() : array
		{
		return $this->post;
		}

	public function setPost(array $post = []) : self
		{
		$this->post = $post;

		return $this;
		}

	public function getFiles() : array
		{
		return $this->files;
		}

	public function setFiles(array $files = []) : self
		{
		$this->files = $files;

		return $this;
		}

	/**
	 * @return array of errors found, for diagnostic information
	 */
	public function getErrors() : array
		{
		return array_keys($this->errors);
		}

	}

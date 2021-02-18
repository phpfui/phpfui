<?php

namespace PHPFUI;

/**
 * # NanoController - A [KISS](https://en.wikipedia.org/wiki/KISS_principle) controller built for speed
 * **NanoController** is an extremely simple and fast controller that uses the URI and not a routing table.
 * ### Why NanoController?
 * Traditional MVC frameworks use a routing table, which ends up being difficult to maintain and not obvious as to what the resulting URI is or what classes end up being invoked.  Routing tables are a level of indirection that are really not needed for projects that define their own pathing, which is basically any business app behind a sign in page. In addition to requiring a complex routing table, the routing table takes up memory and execution time to resolve the route. **NanoController** has virtually no memory footprint and a very fast lookup algorithm. Reduced memory usage and fast execution times are especially important with an interpreted language such as PHP. Time and memory are cumulative, and best avoided where ever possible.
 * ### [KISS](https://www.kissonline.com) - [Keep It Simple Stupid](https://en.wikipedia.org/wiki/KISS_principle)
 * The **NanoController** maps namespaces, classes and methods directly to the URI and dispenses with a routing table.  The result is an easy to understand namespace and classs structure that exactly matches your URI. The URI tells you exactly where the class lives, and the class tells you the exact URI. No need to check a routing table to know what is invoked when.
 * ### Naming Conventions
 * **NanoController** follows standard naming conventions to figure out what namespace, class and method to call.  Namespaces and classes should use [Studly Case](https://mentoor.io/posts/studlycase-vs-camelcase-vs-snakecase/1), capitalized first letter and capitalized letter of every word. Methods should follow [camelCase](https://mentoor.io/posts/studlycase-vs-camelcase-vs-snakecase/1), where the first letter is lowercase, with subsequent word's first letter upper cased, although this is not required, as PHP method names are case insensitive (unfortunately). **NanoController** uses the first lower case segment as the method name. The preceding segments form the namespace and class. The method must be public.
 * ### Parameters
 * You can pass parameters with URI segments past the first lower case segment (which is the method name to call in the class) by simply specifying additional segments.  **NanoController** uses method parameter types to cast the  parameters to the right types.  You can specify any scalar (**bool, int, float, string**), and **NanoController** will cast it to the correct type.  If your parameter type is a class, **NanoController** will instantiate the class and pass the constuctor a string representation of the corresponding URI segment. If you specify **array** as the type, **NanoController** will pass all subsequent URI segments as an array of strings. No other parameters will be passed after an **array** parameter.
 * ### Method Call
 * **NanoController** will instantiate the class (which must impliment **NanoClassInterface**) and call the specified method and pass any provided parameters.  The run method returns the instantiated class with the specified method run. It is your job to deal with the object after that. Generally you would just call its output function (__toString normally) and return a completed page, but it is up to you.
 * ### Landing Pages
 * If a valid method is not found, but the class is, **NanoController** will attempt to call the default missing method if explicitly defined by calling **setMissingMethod**. This allows for a default landing page if a method is not called.  If a default method is not specified, **NanoController** continues up the URI tree looking for a default method.  If no class and default method are found, then the missing page is returned.
 * ### Missing Class
 * Users are prone to not typing in URIs exactly, so if **NanoController** can not find a class, or a class and method to instantiate, it will return a missing class of **App\Missing**, which can be overridden if needed by calling **setMissingClass**. If the namespace and class do not exist, the missing class will be returned.  If the class exists, the missing method will be tried, and if not found, the missing method will be searched for back up the URI tree.
 * ### Examples (assuming default App namespace)
 * | URI | Namespace | Class | Method | Parameters |
 * |-----|-----------|-------|--------|------------|
 * |/Account/Users/list|\App\Account|Users|list()| none |
 * |/Account/Users/edit/4321|\App\Account|Users|edit(int $id)| (int)4321 |
 * |/Account/Users/update/4321|\App\Account|Users|update(\Model\User $user)| new \Model\User('4321') |
 * |/Account/Users/friends/4321/5810/23704/17639/699382|\App\Account|Users|friends(int $id, array $friends)| (int)4321, ['5810', '23704', '17639', '699382'] |
 * |/Account/Users/Fiends|\App|Missing| __construct(NanoController) | none (class not defined) |
 *
 * You can change the root namespace from App to anything by calling setRootNamespace('App\\Controller') for example.
 * ### What about GET, POST, PUT, and DELETE?
 * Unlike complicated routing tables, **NanoController** leaves the handling of HTTP methods to the class. Since browsers only support GET and POST, you have to hack PUT and DELETE methods anyway, so just deal with the HTTP method how ever you see fit.
 */
class NanoController
	{
	private $errors = [];

	private $files = [];

	private $get = [];

	private $invokedPath = '';

	private $missingClass = '';

	private $missingMethod = '';

	private $post = [];

	private $rootNamespace = '';

	private $uri = '';

	/**
	 * Construct the controller.  You generally pass $_SERVER['REQUEST_URI'], but it is up to you.
	 */
	public function __construct(string $uri)
		{
		$this->uri = $uri;
		// initialize all the parameters to defaults
		$reflection = new \ReflectionClass($this);
		$methods = $reflection->getMethods();

		foreach ($methods as $method)
			{
			$name = $method->name;

			if (0 === \strpos($name, 'set'))
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
	 * @return array of errors found, for diagnostic information
	 */
	public function getErrors() : array
		{
		return \array_keys($this->errors);
		}

	public function getFiles() : array
		{
		return $this->files;
		}

	public function getGet() : array
		{
		return $this->get;
		}

	/**
	 * Returns the URI path that was finally loaded
	 */
	public function getInvokedPath() : string
		{
		$invokedPath = \str_replace($this->rootNamespace . '\\', '', $this->invokedPath);

		return \str_replace('\\', '/', $invokedPath);
		}

	public function getPost() : array
		{
		return $this->post;
		}

	/**
	 * Returns the URI provided in the constructor
	 */
	public function getUri() : string
		{
		return $this->uri;
		}

	/**
	 * Run the controller and execute the class and method indicated by the URI
	 *
	 * @return NanoClassInterface object instantiated class with the appropriate method called, except if the missing class is returned, then just the constructor has been called.
	 */
	public function run() : NanoClassInterface
		{
		/**
		 * Iterate through uri looking for a lowercase letter
		 * Lower case letter indicates a method name
		 * look at previous
		 */
		$urlParts = \parse_url($this->uri);
		$parts = \explode('/', \trim($urlParts['path'], '/'));
		$class = \explode('\\', $this->rootNamespace);

		foreach ($parts as $index => $method)
			{
			if (\strlen($method) && \ctype_lower($method[0]))
				{
				$classObject = $this->invokeClassMethod($class, $method, $parts, $index);

				if ($classObject)
					{
					return $classObject;
					}

				return $this->punt($class);
				}
			elseif (! \ctype_alpha($parts[0]))
				{
				// not alpha start, need to punt
				return $this->punt($class);
				}
			// add the part the class
			$class[] = $method;
			}

		return $this->punt($class);
		}

	public function setFiles(array $files = []) : self
		{
		$this->files = $files;

		return $this;
		}

	public function setGet(array $get = []) : self
		{
		$this->get = $get;

		return $this;
		}

	/**
	 * If no class::method is found in the URI, return an instance of this class.
	 */
	public function setMissingClass(string $missingClass = 'App\\Missing') : self
		{
		$this->missingClass = $missingClass;

		return $this;
		}

	/**
	 * If a class is found, but a method is not, then try calling this missing method. If no missing method is defined, go back up the tree looking for this method.
	 */
	public function setMissingMethod(string $missingMethod = '') : self
		{
		$this->missingMethod = $missingMethod;

		return $this;
		}

	public function setPost(array $post = []) : self
		{
		$this->post = $post;

		return $this;
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
	 * Test if the class and method exists, and if so, return the instantiated class with the method called
	 *
	 * @return null|NanoClassInterface null value indicates class::method was not found
	 */
	private function invokeClassMethod(array $class, string $method, array $parts = [], int $index = 0) : ?NanoClassInterface
		{
		$className = \implode('\\', $class);
		// if we are at the root namespace, we are done
		if ($className == $this->rootNamespace)
			{
			return null;
			}

		// should have method name and class, try to invoke
		if (! \class_exists($className))
			{
			$this->errors['Class ' . $className . ' does not exist, returning Missing'] = true;

			return new $this->missingClass($this);
			}

		$message = 'Class Method ' . $className . '::' . $method;
		if (! \method_exists($className, $method))
			{
			$this->errors[$message . ' does not exist'] = true;

			return null;
			}

		$classObject = new $className($this);
		$reflection = new \ReflectionClass($classObject);
		$reflectionMethod = $reflection->getMethod($method);
		if (! $reflectionMethod->isPublic())
			{
			$this->errors[$message . ' is not public'] = true;

			return null;
			}

		$this->invokedPath = $className . '\\' . $method;
		$args = ($index + 1) < \count($parts) ? \array_slice($parts, $index + 1) : [];
		$numberArgs = \count($args);
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
							$arg = \array_slice($args, $argNumber);
							$args = \array_slice($args, 0, $argNumber);
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
	 * We can't find a Class\Method pair, so just find a class and check if it has a landing page if defined, else go up one level.
	 *
	 * @return NanoClassInterface object will return the missing class if the missing method can't be loaded
	 */
	private function punt(array $classParts) : NanoClassInterface
		{
		while (\count($classParts))
			{
			$className = \implode('\\', $classParts);
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
			\array_pop($classParts);
			}

		return new $this->missingClass($this);
		}
	}

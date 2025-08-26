<?php

namespace App\Http\Controllers;

/**
 * --------------------------------------------------------------------------
 * Base Controller (Abstract Class)
 * --------------------------------------------------------------------------
 * This abstract class serves as the foundation for all controllers
 * within the application.
 *
 * ✅ Key Points:
 *  - It is declared as `abstract`, meaning it cannot be instantiated directly.
 *  - All application-specific controllers will extend this class.
 *  - Shared methods, properties, and traits can be defined here to be
 *    inherited across all controllers.
 *  - Promotes code reuse and enforces a consistent structure across
 *    controller implementations.
 *
 * Example:
 *  class SampleController extends Controller {
 *      // Inherits properties and methods from this base class
 *  }
 * --------------------------------------------------------------------------
 */
abstract class Controller
{
    // Common methods and properties for all controllers can be defined here.
}

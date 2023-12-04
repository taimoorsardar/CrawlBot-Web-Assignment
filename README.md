# Web Crawler

## Overview
This PHP-based web crawler is designed to crawl websites, extract information from HTML pages, and store the collected data in a MySQL database. It supports features such as crawling based on depth, searching for specific content, and displaying the crawled data.


## Installation
1. Clone or download the project files to your local machine.
2. Set up a MySQL database and update the database credentials in `crawler.php` and `index.php`.
3. Ensure PHP is installed on your server.
4. Configure your web server to serve the project files.

## Usage

### Crawling
1. Open `index.php` in a web browser.
2. Enter the starting URL and depth in the provided form.
3. Click the "Crawl" button to initiate the crawling process.

### Search
1. Open `index.php` in a web browser.
2. Enter the search query in the provided form.
3. Click the "Search" button to find pages containing the specified content.

--- 

This section provides a high-level overview of the web crawler's functionality. You can adapt and expand this explanation based on additional features or improvements you make to the crawler.
## Project Structure
- `index.php`: Main user interface for initiating crawling and searching. Displays crawled data.
- `crawler.php`: Contains the crawling logic, HTML parsing, and database interactions.

## How It Works

The web crawler is a PHP-based tool designed to systematically navigate through web pages, retrieve information, and store relevant data in a MySQL database. Below is a step-by-step explanation of how the crawler works:

1. **User Input:**
   - The user initiates the crawling process by accessing the `index.php` file through a web browser.
   - In the crawling form, the user provides the starting URL and sets the crawling depth.

2. **Crawling Initialization:**
   - The `index.php` file sends a GET request to `crawler.php` with the specified URL and depth.
   - The `crawler.php` file establishes a connection to the MySQL database and initializes arrays to track crawled and crawling URLs.

3. **Crawling Logic:**
   - The crawler uses a depth-first search algorithm to navigate through the web pages.
   - It retrieves HTML content from each URL, extracts relevant information such as title, description, and keywords, and stores this data in the MySQL database.

4. **URL Extraction:**
   - The crawler parses the HTML content to extract hyperlinks (URLs) present on the page.
   - It normalizes and validates each URL to ensure consistency in the crawling process.

5. **Data Storage:**
   - Extracted information, including the title, description, keywords, and URL, is inserted into the MySQL database using SQL queries.

6. **Depth Limit:**
   - The crawling process continues until the specified depth is reached or until all available links have been explored.
   - The maximum depth is currently set to 5, but this can be customized in the code.

7. **Search Module:**
   - The `index.php` file also provides a search form where users can enter a search query.
   - The crawler, during its traversal, checks for the presence of the search query in the content of the pages. Matches are displayed to the user.

8. **Error Handling:**
   - Basic error handling is implemented, such as checking for a successful database connection and handling SQL query errors.
   - More robust error handling can be added to address various issues that may arise during crawling.

9. **Displaying Crawled Data:**
   - After the crawling process, the `index.php` file queries the database to display the crawled data, including URLs, titles, descriptions, and keywords.

10. **User Interface:**
   - The user interface can be customized by modifying the HTML and CSS in the `index.php` file.

11. **Known Issues:**
   - The README file highlights known issues, including incomplete error handling and depth being hardcoded.

---

## Customization
Feel free to customize the code to suit your needs. You can modify the HTML/CSS for the user interface, adjust the depth limit, or enhance the error handling.

## Known Issues
- 
- The maximum depth limit is hardcoded to 5 in the crawling logic.

## License
This project is licensed under the [MIT License](LICENSE).

---

Feel free to add or modify any sections based on additional information or features you want to highlight.
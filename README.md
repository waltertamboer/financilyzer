Financilyzer
============
A tool that analyzes financial transactions and categorizes them.

## Installing
To install Financilyzer, run ```php composer.phar install --no-dev```. This will download all needed 
dependencies that are needed for Financilyzer to run.

If you would like to execute the unit tests, run ```php composer.phar install``` and it will 
download all development requirements as well.

## Usage
Financilyzer expects a configuration file called financilyzer.xml. The content of the document looks as follow:

```
<?xml version="1.0" encoding="utf-8" ?>
<financilyzer>
  <transformer />
  <readers />
  <accounts />
  <analyzers />
</financilyzer>
```

### &lt;transformer /&gt;
This element defines the path to the XSL which is used to transform the report into HTML.
Example: ```<transformer path="/path/to/template.xsl" />```

### &lt;readers /&gt;
This element contains a list with document readers. Each type of reader parses a document format.
Currently only the CSV format of the dutch bank ING is supported.
Example:
```
<readers>
  <ing-csv>/path/to/document1.csv</ing-csv>
  <ing-csv>/path/to/document2.csv</ing-csv>
  <not-yet-supported-reader>/path/to/document3</not-yet-supported-reader>
</readers>
```

### &lt;accounts /&gt;
The accounts elements can be considered an address book. It converts accounts in the generated report 
to a human readable string.
Example:
```
<accounts>
  <account number="123456">Walter Tamboer</account>
</accounts>
```

### &lt;analyzers /&gt;
This is the most important element of the configuration file. A list with categories is defined here which 
will be used as the rules of the parser. The following rules currently exist:&lt;category /&gt;, &lt;and /&gt;, &lt;or /&gt; and dynamic rules.

An example of how a rule might look:
```
<category name="My Category">
  <from equals="123456" />
  <and>
    <to equals="654321" />
  </and>
</category>
```

Another example showing a transaction from an account to multiple accounts:

```
<category name="My Second Category">
  <from equals="123" />
  <or>
    <to equals="456" />
    <to equals="789" />
  </or>
</category>

The above will be parsed and if the transaction matches the rules, the transaction will be categorized as "My Category".

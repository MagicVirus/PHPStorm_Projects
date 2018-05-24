#!/usr/bin/env bash
echo "Postal address"
xmllint --schema postalAddress.xsd --noout examples/postalAddress.xml

echo "Resource"
xmllint --schema resource.xsd --noout examples/resource.xml

echo "Staffing customer"
xmllint --schema staffingCustomer.xsd --noout examples/staffingCustomer.xml

echo "Document"
xmllint --schema document.xsd --noout examples/document.xml

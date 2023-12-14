import sys
import xml.dom.minidom
import mysql.connector

document = xml.dom.minidom.parse(sys.argv[1])


strDoc = ""
strDoc+=sys.argv[1]

# If url contains hivebrands, then it should be parsed way1
if (strDoc.find("hivebrands") == 0):
    #print("INSIDE HIVEBRANDS TERRITORY")
    goalName = document.getElementsByTagName('h1')[0].childNodes[0].nodeValue
    ProductName = goalName
    #print(ProductName) 
    goalDescription = document.getElementsByTagName('p')
    descriptions = []
    for p in goalDescription:
        for i in p.getElementsByTagName('span'):
            if (i.hasAttribute('class')):
                if (i.getAttribute('class') == "metafield-multi_line_text_field"):
                    for j in i.childNodes:
                        descriptions.append(j.nodeValue)
    ProductDescription = descriptions[0]
    #print(ProductDescription)
    prices = []
    goalPrice = document.getElementsByTagName('span')
    for p in goalPrice:
        for i in p.childNodes:
            if (i.nodeType == i.TEXT_NODE and p.hasAttribute('class')):
                attribute = p.getAttribute('class')
                if (attribute == "price-item price-item--regular"):
                    prices.append(i.nodeValue.strip().replace("$",""))
    ProductPrice = float(prices[0])
    #print(ProductPrice)
    goalImageUrl = document.getElementsByTagName('div')
    sourceImages = []
    for p in goalImageUrl:
        if p.hasAttribute('class'):
            if (p.getAttribute('class') == "product__media media media--transparent"):
                for i in p.getElementsByTagName('img'):
                    if (i.hasAttribute('src')):
                        sourceImages.append(i.getAttribute('src').strip())
    ImageURL = "https:"
    ImageURL+=sourceImages[0]
    #print(ImageURL) 
    rating = []
    goalReviewScore = document.getElementsByTagName('span')
    for p in goalReviewScore:
        if (p.hasAttribute('class')):
            if (p.getAttribute('class') == "stamped-badge"):
                if (p.hasAttribute('data-rating')):
                    rating.append(p.getAttribute('data-rating'))
    if rating:
        ReviewScore = float(rating[0])
    else:
        # default (some cases, the proddidn't allow a review for that product)
        ReviewScore = float(5.0)
    #print(ReviewScore)

# If url contains amway, then it should be parse way2
elif (strDoc.find("amway") == 0):
    #print("Amway file")
    goalName = document.getElementsByTagName('h1')[0].getElementsByTagName('span')[0].childNodes[0].nodeValue.strip()
    ProductName = goalName
    #print(ProductName)
    
    goalDescription = document.getElementsByTagName('div')
    index = 0
    descriptions = []
    for p in goalDescription:
        if (p.hasAttribute('class')):
            if (p.getAttribute('class') == "amw-page-pdp__tab-details js-tab-details"):
                if (index==0):
                    for i in p.getElementsByTagName('p'):
                        for j in i.childNodes:
                            if (j.nodeType == j.TEXT_NODE):
                                if (str(j.nodeValue).find(":") != -1):
                                    continue
                                descriptions.append(j.nodeValue.strip())
                index+=1
    ProductDescription = " ".join(descriptions)
    #print(ProductDescription)

    goalPrice = document.getElementsByTagName('dd')
    prices = []
    for p in goalPrice:
        if (p.hasAttribute('class')):
            if (p.getAttribute('class') == "amw-list-key-value__value amw-list-key-value__value--bold amw-list-key-value__value--text-left amw-list-key-value__value--huge xss-mb-0 auto-pdp-price"):
                for i in p.getElementsByTagName('span'):
                    for j in i.childNodes:
                        if (j.nodeType == j.TEXT_NODE):
                            prices.append(j.nodeValue.strip().replace("$",""))
    ProductPrice = float(prices[0])
    #print(ProductPrice)

    goalImageUrl = document.getElementsByTagName('img')
    urls = []
    for p in goalImageUrl:
        if (p.hasAttribute('class')):
            if (p.getAttribute('class') == "amw-gallery-carousel__img js-carousel-img"):
                if (p.hasAttribute('data-lazy')):
                    urls.append(p.getAttribute('data-lazy'))
    ImageURL = "https://amway.com/"
    ImageURL+=urls[0]
    #print(ImageURL)

    # Disclaimer: unfortunately, tagsoup was unable to parse the Rating from the Amway website, default number will be used
    ReviewScore = float(4.5)
    #print(ReviewScore)

#All attributes on table PRODUCT shall be defined, then insert cursor should be executed


def insert(cursor):
    query = 'INSERT INTO PRODUCTS(ProductName, ProductDescription, ProductPrice, ImageURL, ReviewScore) VALUES(%s, %s, %s, %s, %s)'
    cursor.execute(query, (ProductName, ProductDescription, ProductPrice, ImageURL, ReviewScore))
def update(cursor):
    query = 'UPDATE PRODUCTS(ProductName, ProductDescription, ProductPrice, ImageURL, ReviewScore) SET ProductName = %s, ProductDescription = %s, ProductPrice = $s, ImageURL = %s, ReviewScore = %s  WHERE ProductName = %s'
    cursor.execute(query, (ProductName, ProductDescription, ProductPrice, ImageURL, ReviewScore, ProductName))
try:
    cnx = mysql.connector.connect(host='localhost', user='root', password='password1',database='demo')
    cursor = cnx.cursor()
    getProductsQuery = 'SELECT ProductName FROM PRODUCTS'
    cursor.execute(getProductsQuery)
    result = cursor.fetchall()
    found = False
    for i in result:
        if (ProductName in i):
            found = True
            break
    if (found == False):
        insert(cursor)
    else:
        update(cursor)
    cnx.commit()
    cursor.close()
except mysql.connector.Error as error:
    print(error)
finally:
    cnx.close()

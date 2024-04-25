from flask import Flask, render_template, request, redirect, url_for
import sqlite3


app = Flask(__name__)

# Initialize the SQLite database
db = sqlite3.connect('used_products.db')
cursor = db.cursor()
cursor.execute('''
    CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY,
        title TEXT,
        description TEXT,
        price REAL
    )
''')
db.commit()
db.close()

@app.route('/')
def index():
    db = sqlite3.connect('used_products.db')
    cursor = db.cursor()
    cursor.execute('SELECT * FROM products')
    products = cursor.fetchall()
    db.close()
    return render_template('index.html', products=products)

@app.route('/add_product', methods=['POST'])
def add_product():
    title = request.form['title']
    description = request.form['description']
    price = request.form['price']
    
    db = sqlite3.connect('used_products.db')
    cursor = db.cursor()
    cursor.execute('INSERT INTO products (title, description, price) VALUES (?, ?, ?)', (title, description, price))
    db.commit()
    db.close()
    return redirect(url_for('index'))
if __name__ == '__main__':
    app.run(debug=True)


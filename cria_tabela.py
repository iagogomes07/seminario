import sqlite3

con = sqlite3.connect('banco.db')
cur = con.cursor()

cur.execute('''
    CREATE TABLE IF NOT EXISTS funcionario (
        matricula INTEGER PRIMARY KEY,
        nome TEXT NOT NULL
    )
''')

con.commit()
con.close()

print("Tabela criada com sucesso!")
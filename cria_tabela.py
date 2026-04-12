import sqlite3

def criar_tabela():
    conexao = sqlite3.connect("tarefas.db")
    cursor = conexao.cursor()

    cursor.execute("""
    CREATE TABLE IF NOT EXISTS tarefas (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        titulo TEXT NOT NULL,
        descricao TEXT,
        data_entrega TEXT NOT NULL,
        status TEXT NOT NULL
    )
    """)

    conexao.commit()
    conexao.close()
    print("Banco de dados e tabela criados com sucesso!")

if __name__ == "__main__":
    criar_tabela()
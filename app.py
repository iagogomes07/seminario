import sqlite3

# Função conectar
def conectar():
    return sqlite3.connect("banco.db")

# CREATE
def inserir(matricula, nome):
    con = conectar()
    cur = con.cursor()
    cur.execute("INSERT INTO funcionario VALUES (?, ?)", (matricula, nome))
    con.commit()
    con.close()
    print("Inserido com sucesso!")

# READ
def listar():
    con = conectar()
    cur = con.cursor()
    cur.execute("SELECT * FROM funcionario")
    dados = cur.fetchall()
    con.close()
    return dados

# UPDATE
def atualizar(matricula, novo_nome):
    con = conectar()
    cur = con.cursor()
    cur.execute("UPDATE funcionario SET nome = ? WHERE matricula = ?", (novo_nome, matricula))
    con.commit()
    con.close()
    print("Atualizado com sucesso!")

# DELETE
def excluir(matricula):
    con = conectar()
    cur = con.cursor()
    cur.execute("DELETE FROM funcionario WHERE matricula = ?", (matricula,))
    con.commit()
    con.close()
    print("Excluído com sucesso!")


# MENU PARA TESTAR
while True:
    print("\n=== CRUD Funcionário ===")
    print("1 - Inserir")
    print("2 - Listar")
    print("3 - Atualizar")
    print("4 - Excluir")
    print("5 - Sair")

    op = input("Opção: ")

    if op == "1":
        m = int(input("Matrícula: "))
        n = input("Nome: ")
        inserir(m, n)

    elif op == "2":
        dados = listar()
        for d in dados:
            print(d)

    elif op == "3":
        m = int(input("Matrícula para atualizar: "))
        n = input("Novo nome: ")
        atualizar(m, n)

    elif op == "4":
        m = int(input("Matrícula para excluir: "))
        excluir(m)

    elif op == "5":
        break

    else:
        print("Opção inválida.")
export type Cargo = {
    id: string;
    nome: string;
  };
  
  export type Turma = {
    id: string;
    [key: string]: string;
  };
  
  export type Pessoa = {
    nome: string;
    dataNascimento: string;
    cargo: Cargo;
    turma: Turma | null;
  };
  
  export type ApiResponse = {
    Aniversariantes: string;
    dados: Record<string, Pessoa>;
  };
  